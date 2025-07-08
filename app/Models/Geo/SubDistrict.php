<?php

namespace App\Models\Geo;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubDistrict extends GeoModel
{
    protected $table = 'geo_sub_districts';

    /** @inheritdoc */
    protected $fillable = [
        'country_id', 'province_id', 'city_id', 'district_id',
        'code', 'local_code', 'name', 'postal_code',
        'longitude', 'latitude', 'altitude'
    ];

    //== Relationships ==//

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'province_id', 'id');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }
}
