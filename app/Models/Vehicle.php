<?php

namespace App\Models;

use App\Enums\StatusType;
use App\Enums\VehicleType;
use App\Vendor\LaravelHashId\Eloquent\HashableId;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property int $id
 * @property string $hashid
 * @property string $code
 * @property string $name
 * @property string $type
 * @property string $value
 * @property array $additional
 * @property int $total_vehicles
 * @property bool $in_use
 * @property bool $is_active
 * @property int $sort
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class Vehicle extends Model implements HasMedia
{
    use SoftDeletes;
    use HashableId;
    use InteractsWithMedia;

    protected $table = 'vehicles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'hash_id', 'code', 'name', 'type', 'status', 'value', 'additional', 'total_vehicles', 'is_active', 'sort',
        'created_by', 'updated_by',
        'created_at', 'updated_at', 'deleted_at'
    ];
    
    /** @inheritdoc */
    protected $attributes = [
        'type' => VehicleType::FREIGHTTRANSPORT,
    ];

    protected function casts(): array
    {
        return [
            'hash_id' => 'string',
            'type' => VehicleType::class,
            'additional' => 'array',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    public function vechicleOrders()
    {
        return $this->hasMany(VehicleOrder::class, 'vehicle_id', 'id')
            ->where('status', StatusType::APPROVED);
    }
}
