<?php

namespace App\Models\Geo;

use App\Contracts\HasGeoModel;
use App\Models\Model;
use App\Vendor\LaravelHashId\Eloquent\HashableId;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method Builder relatedId(string $key, string|int $value)
 */
abstract class GeoModel extends Model implements HasGeoModel
{
    use HasFactory, SoftDeletes, HashableId;

    public function scopeRelatedId(Builder $qry, string $key, string|int $value): Builder
    {
        if ($this->isFillable($key)) {
            if (is_string($value)) {
                $value = match($key) {
                    'country_id' => Country::hashToId($value),
                    'province_id' => Province::hashToId($value),
                    'city_id' => City::hashToId($value),
                    'district_id' => District::hashToId($value),
                    'sub_district_id' => SubDistrict::hashToId($value),
                    default => null,
                };
            }

            if ($value) {
                $qry->where($this->qualifyColumn($key), $value);
            }
        }
        return $qry;
    }
}
