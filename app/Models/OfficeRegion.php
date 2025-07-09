<?php

namespace App\Models;

use App\Vendor\LaravelHashId\Eloquent\HashableId;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property int $id
 * @property string $hashid
 * @property string $code
 * @property string $name
 * @property string $value
 * @property array $options
 * @property bool $is_active
 * @property int $sort
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class OfficeRegion extends Model implements HasMedia
{
    use SoftDeletes;
    use HashableId;
    use InteractsWithMedia;

    protected $table = 'office_regions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'hash_id', 'code', 'name', 'value', 'additional', 'is_active', 'sort',
        'created_by', 'updated_by',
        'created_at', 'updated_at', 'deleted_at'
    ];

    protected function casts(): array
    {
        return [
            'additional' => 'array',
            'is_active' => 'boolean',
            'sort' => 'integer',
        ];
    }

    //== Relationship
    public function mine()
    {
        return $this->hasMany(Mine::class, 'office_region_id');
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
