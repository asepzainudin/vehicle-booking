<?php

namespace App\Core\Notification\Drivers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class MsNotif extends NotificationDriver
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
            $baseUrl = preg_replace('/\/+$/', '', config('msnotif.host'));
            $client = Http::baseUrl("$baseUrl/api/")
                ->withOptions([
                    'verify' => config('msnotif.secure'),
                    'allow_redirects' => false,
                    'timeout' => 180,   // 3 menit
                ]);

            $resp = $client->post('send', $params);
            $body = fluent($resp->json() ?? []);

            $this->isSuccess = $resp->successful();
            $this->responseCode = $this->isSuccess ? 'ok' : 'rto';
            $this->responseId = (string) $body->data['id'] ?? '';
            $this->responseStatus = strtolower($body->rc ?? 'unknown');
            $this->responseMessage = strtolower($body->rc ?? 'unknown');
            $this->createdAt = (string) $body->data['created_at'] ?? '';
            $this->rawResponse = $body->toArray();

            return $this->isSuccess;
        } catch (\Throwable $e) {

            $this->isSuccess = false;
            $this->responseCode = 'failed';
            $this->responseId = 'msnotif:fail-'.Str::uuid()->toString();
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
