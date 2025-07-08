<?php

namespace App\Core\Notification;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Notification License model.
 *
 * @author      yusron arif <yusron.arif4@gmail.com>
 *
 * @property int $id
 * @property string $type
 * @property string $name
 * @property string $license
 * @property string $token
 * @property string $status
 * @property \Illuminate\Support\Carbon $expires_at
 */
class NotificationLicense extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'notification_licenses';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'name', 'license', 'token', 'expires_at', 'status',
    ];

    protected $dates = [
        'expires_at',
    ];
}
