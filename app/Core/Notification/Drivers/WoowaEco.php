<?php

namespace App\Core\Notification\Drivers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class WoowaEco extends NotificationDriver
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
            $baseUrl = preg_replace('/\/+$/', '', config('msnotif.woowa.eco.host'));
            $client = Http::baseUrl("$baseUrl/api/")
                ->withOptions([
                    'verify' => false,
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
            $body = fluent((array) $resp->json());
            $bodyResp = fluent((array) $resp->json('response'));

            // dump($body, $bodyResp);

            $this->isSuccess = $resp->successful();
            $this->responseCode = $this->isSuccess ? 'ok' : 'rto';
            $this->responseId = 'eco-'.Str::uuid()->toString();
            $this->responseStatus = $body->toJson();
            $this->responseMessage = $body->toJson();
            $this->createdAt = carbon()->toDateTimeString();
            $this->rawResponse = [
                'rc' => $this->responseCode,
                'message' => $this->responseMessage,
                'data' => [
                    'id' => $this->responseId,
                    'created_at' => $this->createdAt,
                ]
            ];

            return true;
        } catch (\Throwable $e) {

            $this->isSuccess = false;
            $this->responseCode = 'failed';
            $this->responseId = 'eco:fail-'.Str::uuid()->toString();
            $this->responseStatus = (string) $e->getCode();
            $this->responseMessage = $e->getMessage();
            $this->createdAt = carbon()->toDateTimeString();
            $this->rawResponse = [
                'rc' => $this->responseCode,
                'message' => $this->responseMessage,
                'data' => [
                    'id' => $this->responseId,
                    'created_at' => $this->createdAt,
                ]
            ];
            if (app()->hasDebugModeEnabled()) {
                $this->rawResponse['trace'] = $e->getTrace(); // $e->getTraceAsString();
            }

            return false;
        }
    }
}
