<?php

namespace App\Models;

use App\Vendor\LaravelHashId\Eloquent\HashableId;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property int $id
 * @property string $hashid
 * @property int $office_region_id
 * @property string $uuid
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
class Mine extends Model implements HasMedia
{
    use SoftDeletes;
    use HashableId;
    use InteractsWithMedia;

    protected $table = 'mine';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'hash_id', 'office_region_id', 'code', 'name', 'value',  'additional', 'is_active', 'sort',
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
    public function officeRegion()
    {
        return $this->belongsTo(OfficeRegion::class, 'office_region_id');
    }

}
