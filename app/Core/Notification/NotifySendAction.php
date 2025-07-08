<?php

namespace App\Core\Notification;

use Exception;
use Illuminate\Http\Client\RequestException;

class NotifySendAction
{
    use Concerns\HasLog;

    public array $body = [];

    /**
     * Create a new job instance.
     *
     * @param  string  $processId
     * @param  array  $tags
     */
    public function __construct(
        protected readonly string $processId,
        protected readonly array $tags = []
    ) {
        // $this->sendIt();
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function sendIt(): void
    {
        try {
            if (!in_array(app()->environment(), ['production', 'staging', 'demo']) && !config('msnotif.allow_local')) {
                throw new Exception("your environment is set as ". app()->environment() .", this feature only active for production, and demo". 400);
            }

            $notifyLog = NotificationLog::query()->where('process_id', $this->processId)->first();
            if (! $notifyLog instanceof NotificationLog) {
                throw new Exception("notification with process-id {$this->processId} not found". 400);
            }

            $channel = $notifyLog->channel;
            $isGroup = $notifyLog->is_group;
            // $this->tags = $loggedNotif->tags;
            $params = [
                "sender" => $notifyLog->sender, // nullable
                "receiver" => $notifyLog->receiver, // required, string
                "channel" => $notifyLog->channel, // required, string
                "content" => $notifyLog->content, // required, string
                "attachments" => $notifyLog->attachments ?? [],
            ];

            $notify = match($channel) {
                'woowa',
                'woowa_eco' => new Drivers\Woowa(),
                'wauwa' => new Drivers\Wauwa(),
                default => new Drivers\MsNotif(),
            };

            $notify->send($params, $isGroup);
            $this->body = $notify->rawResponse;

            NotificationLog::updateLog($this->processId, 'successfully', [
                'sent_endpoint' => $notify->requestEndpoint,
                'sent_status' => $notify->isSuccess ? 'ok' : 'rto',
                'resp_status' => $notify->responseStatus,
                'resp_id' => $notify->responseId,
                'requested_at' => $notify->createdAt,
                'raw_response' => $notify->rawResponse,
            ]);

        } catch (RequestException $e) {
            toSentry($e);
            $req = $e->getRequest();
            static::logError('error http request', [
                'request' => [
                    'uri' => $req->getUri(),
                    'target' => $req->getRequestTarget(),
                    'headers' => $req->getHeaders(),
                    'body' => $req->getBody(),
                ]
            ], $e);

            NotificationLog::updateLog($this->processId, 'error http request', [
                'raw_response' => [
                    'request_uri' => $req->getUri(),
                    'request_target' => $req->getRequestTarget(),
                    'request_headers' => $req->getHeaders(),
                    'request_body' => $req->getBody(),
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                    'traces' => $e->getTraceAsString(),
                ],
            ], $e);

        } catch (Exception $e) {
            toSentry($e);
            // $respCode = $e->getCode();
            static::logError('error send notif', throw: $e);

            NotificationLog::updateLog($this->processId, 'error send notif', [
                'raw_response' => [
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                    'traces' => $e->getTraceAsString(),
                ],
            ], $e);
        }
    }
}
