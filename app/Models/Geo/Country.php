<?php

namespace App\Models\Geo;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends GeoModel
{
    public const int ID_INDONESIA = 114;

    /** @inheritdoc */
    protected $table = 'geo_countries';

    /** @inheritdoc */
    protected $fillable = [
        'iso2', 'iso3', 'name',
        'locale', 'timezone',
        'longitude', 'latitude', 'altitude'
    ];

    //== Relationships ==//

    public function provinces(): HasMany
    {
        return $this->hasMany(Province::class, 'country_id', 'id');
    }

    public function cities(): HasMany
    {
        return $this->hasMany(City::class, 'province_id', 'id');
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
