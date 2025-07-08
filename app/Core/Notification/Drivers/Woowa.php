<?php

namespace App\Core\Notification\Drivers;

use Exception;
use Illuminate\Http\Client\Response as HttpResponse;
use Illuminate\Support\Fluent;
use Illuminate\Support\Str;
use Throwable;

class Woowa extends NotificationDriver
{
    private Fluent $param;
    private string $key = '';
    private string $phoneNumber = '';
    private string $groupId = '';
    private string $message = '';
    private string $path = '';

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->asAsync = config('msnotif.driver.woowa.sync') == 'async';
        $this->setClient(
            preg_replace('/\/+$/', '', config('msnotif.driver.woowa.host'))
        );
        // LogDb::info('sync status', ['config' => config('services.woowa.sync'), 'status' => $this->asAsync]);
    }

    /**
     * @param  array  $params
     * @param  bool  $isGroup
     *
     * @return bool
     * @throws Exception
     */
    public function send(
        array $params = [],
        bool $isGroup = false
    ): bool {
        $this->param = new Fluent($params);

        // $this->client->
        $this->key = $this->param->get('sender', '');
        $this->message = $this->param->get('content', '');
        $this->path = $this->param->get('path', '');
        // $this->attachments = $this->param->get('attachments');

        if ($isGroup) {
            $this->groupId = $this->param->get('receiver', '');
            return $this->groupText();
        }

        $this->phoneNumber = $this->param->get('receiver', '');
        return $this->phoneText();
    }

    /**
     * @return bool
     */
    protected function phoneText(): bool
    {
        try {
            $this->requiredAll(
                $this->key,
                $this->phoneNumber,
                $this->message
            );

            $path = $this->asAsync ? 'async_send_message' : 'send_message';
            $response = $this->client->post($path, [
                'key' => $this->key,
                'phone_no' => $this->phoneNumber,
                'message' => $this->message,
            ]);
            $this->buildResponse($response);
        } catch (Throwable $e) {
            toSentry($e);
            // dump('woowa fail');
            static::logError('[WooWa] fail on sending to phone number', throw: $e);
            $this->buildResponse($e);
        }

        return $this->isSuccess;
    }

    /**
     * @return bool
     */
    protected function groupText(): bool
    {
        try {
            $this->requiredAll(
                $this->key,
                $this->groupId,
                $this->message
            );

            $path = $this->asAsync ? 'async_send_message_group_id' : 'send_message_group_id';
            $response = $this->client->post($path, [
                'key' => $this->key,
                'group_id' => $this->groupId,
                'message' => $this->message,
            ]);
            $this->buildResponse($response);
        } catch (Throwable $e) {
            toSentry($e);
            static::logError('[WooWa] fail on sending to whatsapp group', throw: $e);
            $this->buildResponse($e);
        }

        return $this->isSuccess;
    }

    /**
     * @param  array  $params
     *
     * @return void
     */
    private function buildParams(array $params): void
    {
        $this->param = new Fluent($params);

        $this->key = $this->param->get('sender', '');
        $this->phoneNumber = $this->param->get('recipient', '');
        $this->groupId = $this->param->get('recipient', '');
        $this->message = $this->param->get('content', '');
        $this->path = $this->param->get('url', '');
    }

    /**
     * @param  HttpResponse|Throwable  $response
     *
     * @return void
     */
    private function buildResponse(HttpResponse|Throwable $response): void
    {
        $this->isSuccess = false;
        // $responseBody = null;
        $responseId = null;
        $responseCode = 'failed';
        $responseStatus = null;
        $responseMessage = null;
        $responseTrace = null;
        $rawStatus = null;

        if ($response instanceof HttpResponse) {
            $responseBody = $response->body();
            $this->isSuccess = $response->successful();
            $responseCode = $this->isSuccess ? 'ok' : 'failed';
            $responseStatus = $response->json('status') ?? $response->body();
            $responseMessage = $response->json('data') ?? $response->body();
            $rawStatus = $response->status();
            $responseId = is_numeric($responseBody)
                ? $responseBody
                : 'woowa:'.Str::uuid()->toString();
        }

        if ($response instanceof Throwable) {
            // $responseBody = $response->getMessage();
            $responseStatus = $response->getCode();
            $responseMessage = $response->getMessage();
            $responseId = 'woowa:fail-'.Str::uuid()->toString();
            if (config('msnotif.log.trace') || app()->hasDebugModeEnabled()) {
                $responseTrace = explode(PHP_EOL, $response->getTraceAsString());
            }

            static::logError('[WooWa] failed send message');
        }

        $this->responseCode = $responseCode;
        $this->responseId = $responseId;
        $this->responseStatus = (string) $responseStatus;
        $this->responseMessage = (string) $responseMessage;
        $this->createdAt = carbon()->toDateTimeString();
        $this->rawResponse = [
            'rc' => $this->responseCode,
            'status' => $rawStatus ?? $this->responseStatus,
            'message' => $this->responseMessage,
            'data' => [
                'id' => $this->responseId,
                'created_at' => $this->createdAt,
            ],
        ];
        if ($responseTrace) {
            $this->rawResponse['trace'] = $responseTrace;
        }
    }
}
