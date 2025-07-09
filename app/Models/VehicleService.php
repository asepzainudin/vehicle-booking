<?php

namespace App\Models;

use App\Vendor\LaravelHashId\Eloquent\HashableId;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property int $id
 * @property string $hashid
 * @property int $vehicle_id
 * @property string $date_service
 * @property array $additional
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class VehicleService extends Model implements HasMedia
{
    use SoftDeletes;
    use HashableId;
    use InteractsWithMedia;

    protected $table = 'vehicle_usages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'hash_id', 'vehicle_id', 'date_service', 'additional',
        'created_by', 'updated_by',
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by'); 
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
