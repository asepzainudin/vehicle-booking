<?php

namespace App\Core\Notification\Drivers;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class Wauwa extends NotificationDriver
{
    /**
     * @param array $params
     * @param bool $isGroup
     * @return bool
     */
    public function send(array $params = [], bool $isGroup = false): bool
    {
        $this->isGroup = $isGroup;

        try {
            $baseUrl = preg_replace('/\/+$/', '', config('msnotif.wauwa.host'));
            $client = Http::baseUrl("$baseUrl/api/")
                ->withOptions([
                    'verify' => config('msnotif.wauwa.secure'),
                    'allow_redirects' => false,
                    'timeout' => 180,   // 3 menit
                ]);

            $path = $isGroup ? 'send_message_group_id' : 'send_message';
            $data = [
                'key' => $params['sender'] ?? '',
                $isGroup ? 'group_id' : 'phone_no' => $params['receiver'] ?? '',
                'message' => $params['content'] ?? ''
            ];

            $resp = $client->post($path, $data);
            $body = fluent($resp->json() ?? []);
            $bodyResp = fluent($body->response ?? []);

            $this->isSuccess = (bool) ($body->status ?? $resp->successful());
            $this->responseCode = $this->isSuccess ? 'ok' : 'rto';
            $this->responseId = $bodyResp->id ?? 'wauwa-'.Str::uuid()->toString();
            $this->responseStatus = $this->isSuccess ? 'success' : 'failed';
            $this->responseMessage = $this->responseStatus;
            $this->createdAt = ($bodyResp->timestamp ? Carbon::createFromTimestamp($bodyResp->timestamp) : carbon())->toDateTimeString();
            $this->rawResponse = $body->toArray();

            return $this->isSuccess;
        } catch (\Throwable $e) {

            $this->isSuccess = false;
            $this->responseCode = 'failed';
            $this->responseId = 'wauwa:fail-'.Str::uuid()->toString();
            $this->responseStatus = (string) $e->getCode();
            $this->responseMessage = $e->getMessage();
            $this->createdAt = carbon()->toDateTimeString();
            $this->rawResponse = [
                'rc' => $this->responseCode,
                'data' => [
                    'id' => $this->responseId,
                    'created_at' => $this->createdAt,
                ]
            ];

            return false;
        }
    }
}
