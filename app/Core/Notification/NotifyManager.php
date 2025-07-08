<?php

namespace App\Core\Notification;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Throwable;

class NotifyManager
{
    use Concerns\HasLog;

    /**
     * @param  string  $channel
     * @param  string|null  $sender
     * @param  array  $tags
     */
    public function __construct(
        private string $channel,
        private string|null $sender = null,
        private array $tags = [],
        private int|null $partnerId = null
    ) {
        // if (empty($sender) && !empty($channel) && $channel == 'woowa') {
        //     $this->sender = config('app.msnotif_woowa_sender');
        // }
        if (str($this->channel)->contains('woowa', true)) {
            $this->channel = 'woowa';
        }
    }

    /**
     * @param  string  $key
     * @param  string  $content
     * @param  string  $sender
     * @param  string  $recipient
     * @param  bool  $isGroup
     * @param  array  $attachments
     * @param  string  $type
     *
     * @return bool
     * @throws Throwable
     */
    public function send(
        string $key,
        string $content,
        string $sender = '',
        string $recipient = '',
        bool $isGroup = false,
        array $attachments = [],
        string $type = 'system'
    ): bool {
        $notifyLog = null;

        if (!$this->getStatusActive($this->channel)) {
            static::logError('send notif', [
                'code' => 400,
                'message' => 'Notification service in-active',
            ]);
            return false;
        }
        
        if (empty(trim($sender))) {
            $sender = $this->sender;
        }
        $prefMessage = '';
        if (in_array($this->channel, ['woowa', 'woowa_eco'])) {
            $recipient = preg_replace('/\s+/', '', $recipient);
            $prefMessage = $isGroup ? 'grup ' : 'nomor ';

            if (!$isGroup) {
                $recipient = preg_replace(['/^(0|\+?62|(?!0|\+?62|\+))(.*)$/', '/\++/'], ['62${2}', ''], $recipient);
            }
        }

        $processId = Str::uuid()->toString();
        $logData = [
            'partner_id' => $this->partnerId,
            'status' => NotifyStatus::PENDING,
            'process_id' => $processId,
            'channel' => $this->channel,
            'source' => $key,
            'sender' => $sender,
            'receiver' => $recipient,
            'content' => $content,
            'attachments' => $attachments,
            'type' => $type,
            'is_group' => $isGroup,
            'request_id' => app('request_id') ?? null,
        ];

        try {
            $notifyLog = NotificationLog::query()->create($logData);
        } catch (Exception $e) {
            //
            throw_if(debugNonProduction(), $e);
            toSentry($e);
            static::logError('prepare notif', throw: $e);
        }

        try {
            if (empty($sender) || empty($recipient)) {
                $respMessage = 'Sender tidak diketahui';
                if (empty($recipient)) {
                    $respMessage = $prefMessage . 'penerima tidak diketahui';
                }

                if ($notifyLog instanceof NotificationLog) {
                    $notifyLog->update([
                        'sent_status' => 'failed',
                        'resp_status' => $respMessage,
                    ]);
                }

                throw new Exception("failed: $respMessage" . 400);
            }

            // not yet using this jobs for whatstApp
            if (! in_array($logData['channel'], ['woowa', 'woowa_eco', 'wauwa'])) {
                dispatch(new NotifySender(
                    processId: $processId,
                    tags: $this->tags
                ))->onQueue('notification');
            }
            elseif (in_array($logData['channel'], ['woowa', 'woowa_eco'])) {
                event(new Events\NotifyCreated($logData['channel'], $logData['sender']));
            }

            return true;
        } catch (Exception $e) {
            throw_if(debugNonProduction(), $e);
            toSentry($e);
            static::logError('send notif', throw: $e);
        }

        return false;
    }

    /**
     * @param  string  $operationId
     *
     * @return array
     * @throws GuzzleException
     */
    public function get(string $operationId = ''): array
    {
        $path = "";
        if (!empty(trim($operationId))) {
            $path = $operationId;
        }
        $baseUrl = preg_replace('/\/+$/', '', config('app.msnotif_url')) . '/api/notification/';
        $client = new Client([
            'base_uri' => $baseUrl,
            'verify' => false,
            'timeout' => 60,    // 1 menit
            'debug' => true
        ]);

        try {
            $response = $client->get($path);
            return json_decode($response->getBody()->getContents(), true) ?? [];

        } catch (Exception $e) {
            static::logError('get info', throw: $e);
        }

        return [];
    }

    /**
     * @param  string  $channel
     *
     * @return bool
     */
    public function getStatusActive(string $channel): bool
    {
        return str($channel)->isNotEmpty();
        // if (empty($this->schoolId)) return false;
        //
        // switch ($channel) {
        //     case 'email':
        //         $key = 'email';
        //         break;
        //     case 'fcm':
        //         $key = 'fcm';
        //         break;
        //     case 'sms':
        //         $key = 'sms';
        //         break;
        //     case 'telegram':
        //         $key = 'telegram';
        //         break;
        //     case 'whatsapp':
        //     case 'wauwa':
        //     case 'woowa':
        //     case 'woowa_eco':
        //         $key = 'whatsapp';
        //         break;
        //     default:
        //         return false;
        // }
        //
        // try {
        //     $notifKeys = SchoolData::where('school_id', $this->schoolId)->where('key', 'notifications')->first();
        // } catch (Exception $e) {
        //     return false;
        // }
        //
        // if ($notifKeys instanceof SchoolData == false) {
        //     return false;
        // }
        //
        // $notifKeys = explode(',', $notifKeys->value ?? '');
        // return in_array($key, $notifKeys);
    }
}
