<?php

namespace App\Models\Geo;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends GeoModel
{
    /** @inheritdoc */
    protected $table = 'geo_cities';

    /** @inheritdoc */
    protected $fillable = [
        'country_id', 'province_id',
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

    public function districts(): HasMany
    {
        return $this->hasMany(District::class, 'city_id', 'id');
    }

    public function sub_districts(): HasMany
    {
        return $this->hasMany(SubDistrict::class, 'city_id', 'id');
    }
}
