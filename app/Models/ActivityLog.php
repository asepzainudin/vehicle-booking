<?php

namespace App\Models;

use App\Vendor\LaravelHashId\Eloquent\HashableId;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property int $id
 * @property string $causer_type
 * @property int $causer_id
 * @property string $subject_type
 * @property int $subject_id
 * @property string $event
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class ActivityLog extends Model implements HasMedia
{
    use SoftDeletes;
    use HashableId;
    use InteractsWithMedia;

    protected $table = 'activity_logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'causer_type', 'causer_id', 'subject_type', 'subject_id', 'event', 'description',
    ];
}
