<?php

namespace App\Models\Base;

use App\Contracts\Base\UsingAddress;
use App\Models\Model;
use App\Vendor\LaravelHashId\Eloquent\HashableId;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model implements UsingAddress
{
    use SoftDeletes;
    use HashableId;

    /** @var bool */
    protected bool $shouldHashPersist = true;

    /** @inheritdoc */
    protected $table = 'addresses';

    /** @inheritdoc */
    protected $fillable = [
        'model_type', 'model_id',
        'is_primary', 'name', 'phone',
        'address', 'rt_rw', 'postal_code',
        'country_id', 'country_name', 'province_id', 'province_name',
        'city_id', 'city_name', 'district_id', 'district_name',
        'sub_district_id', 'sub_district_name',
        'longitude', 'latitude', 'altitude',
    ];

    //== Relationships

    public function addressable(): MorphTo
    {
        return $this->morphTo('addressable', 'model_type', 'model_id');
    }

    //== Methods
}
