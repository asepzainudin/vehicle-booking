<?php

namespace App\Models\Geo;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Province extends GeoModel
{
    /** @inheritdoc */
    protected $table = 'geo_provinces';

    /** @inheritdoc */
    protected $fillable = [
        'country_id', 'code', 'local_code', 'name', 'postal_code',
        'locale', 'timezone',
        'longitude', 'latitude', 'altitude'
    ];

    //== Relationships ==//

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function cities(): HasMany
    {
        return $this->hasMany(City::class, 'province_id', 'id');
    }

    public function districts(): HasMany
    {
        return $this->hasMany(District::class, 'province_id', 'id');
    }

    public function sub_districts(): HasMany
    {
        return $this->hasMany(SubDistrict::class, 'province_id', 'id');
    }
}
