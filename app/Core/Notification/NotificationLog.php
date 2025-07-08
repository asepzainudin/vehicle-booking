<?php

namespace App\Core\Notification;

use Exception;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;

/**
 * @property string $id
 * @property int $license_id
 * @property string $process_id
 * @property string $channel
 * @property string $source
 * @property string $sender
 * @property string $receiver
 * @property string $content
 * @property array|null $attachments
 * @property string $status
 * @property string $sent_endpoint
 * @property string $sent_status
 * @property string $resp_status
 * @property string $resp_id
 * @property string $channel_status
 * @property string $type
 * @property string $requested_at
 * @property bool $is_group
 * @property array|null $tags
 * @property string $request_id
 * @property string $sender_request_id
 * @property array|null $raw_response
 */
class NotificationLog extends Model
{
    use HasUuids;
    use SoftDeletes;
    use Concerns\HasLog;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'notification_logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'partner_id', 'license_id', 'process_id', 'channel', 'source',
        'sender', 'receiver', 'content', 'attachments',
        'status', 'sent_endpoint', 'sent_status',
        'resp_status', 'resp_id', 'channel_status',
        'type', 'requested_at', 'is_group', 'tags',
        'request_id', 'sender_request_id', 'raw_response',
    ];

    protected $casts = [
        'status' => NotifyStatus::class,
        'attachments' => 'array',
        'tags' => 'array',
        'raw_response' => 'array',
    ];

    // public function status(): Attribute
    // {
    //     return Attribute::make(
    //         get: function ($value) {
    //             $value = NotifyStatus::tryFrom($value);
    //             if (! $value instanceof NotifyStatus) {
    //                 $value = NotifyStatus::UNHANDLED_ERROR;
    //             }
    //             return $value;
    //         },
    //         set: function ($value) {
    //             if (! $value instanceof NotifyStatus) {
    //                 $value = NotifyStatus::tryFrom($value);
    //                 if (! $value instanceof NotifyStatus) {
    //                     $value = NotifyStatus::UNHANDLED_ERROR;
    //                 }
    //             }
    //             return $value->value;
    //         }
    //     );
    // }

    public function sentStatus(): Attribute
    {
        return Attribute::make(
            set: fn($value) => substr($value, 0, 250),
        );
    }

    public function respStatus(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $this->tryCheckIfNotifyStatus($value),
        );
    }

    public function channelStatus(): Attribute
    {
        return Attribute::make(
            set: fn($value) => substr($value, 0, 250),
        );
    }

    private function tryCheckIfNotifyStatus($value): string
    {
        if ($value instanceof NotifyStatus) {
            return $value->value;
        }
        return substr($value, 0, 250);
    }

    /**
     * @param  string  $processId
     * @param  string  $moment
     * @param  array  $data
     * @param  Exception|null  $exception
     *
     * @return void
     * @throws \Throwable
     */
    public static function updateLog(
        string $processId,
        string $moment = 'successfully',
        array $data = [],
        Exception|null $exception = null,
    ): void {
        if ($data['sent_endpoint']) {
            $data['sent_endpoint'] = str($data['sent_endpoint'])->substr(0, 255);
        }

        try {
            $xData = fluent(Arr::dot($data));

            if ($exception instanceof Exception) {
                $data['status'] = NotifyStatus::UNHANDLED_ERROR;
                $data['sent_status'] = 'failed';
                $data['resp_status'] = substr("[{$moment}] {$exception->getCode()}: {$exception->getMessage()}", 0, 255);

            } else {
                $data['status'] = $xData->get('raw_response.rc') == 'failed'
                    ? NotifyStatus::FAIL
                    : NotifyStatus::SUCCESS;
                if (str($xData->get('resp_id'))->startsWith('woowa:fail-')) {
                    $data['resp_status'] = NotifyStatus::FAIL->value;
                    $data['status'] = NotifyStatus::FAIL;

                } elseif (empty($xData->get('resp_status'))) {
                    if (is_numeric($data['resp_status'])) {
                        $data['resp_status'] = NotifyStatus::AWAIT->value;
                        $data['status'] = NotifyStatus::AWAIT;

                    } else {
                        $data['resp_status'] = $moment;
                    }
                }
            }
            $data['sender_request_id'] = app('request_id') ?? '';

            if(is_array($data) && !empty($data)){
                static::query()
                    ->where('process_id', $processId)
                    ->first()
                    ->update($data);
            }

        } catch (Exception $ex) {
            toSentry($ex);
            // throw_if(debugNonProduction(), $ex);
            static::logError("{$moment} - update logs", [
                'process-id' => $processId,
            ], $ex);
        }
    }
}
