<?php

namespace App\Models;

use App\Contracts\Partner\HasPartner;
use App\Contracts\Tenant\HasTenant;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;

abstract class Model extends \Illuminate\Database\Eloquent\Model
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if (property_exists($this, 'appendsMore')) {
            $this->appends = array_merge($this->appendsMore, $this->appends);
        }
    }

    /** @inheritdoc */
    protected static function booting(): void
    {
        static::creating(function ($model) {
            if ($model instanceof HasPartner) {
                if (! $model->hasAttribute($model::partnerKey())) {
                    $model->setAttribute($model::partnerKey(), authPartnerId());
                }
            }
        });
    }

    public static function cleanQuery(): Builder
    {
        return (new static)->newModelQuery();
    }

    public static function rawQuery(): QueryBuilder
    {
        $instance = (new static);
        return DB::connection($instance->getConnectionName())->table($instance->getTable());
    }

    /**
     * Get Hash Attribute.
     *
     * @return string|null
     * @throws BindingResolutionException
     */
    public function getHashAttribute(): ?string
    {
        if (! method_exists($this, 'getHashKey')) {
            return null;
        }
        return $this->getKey() && $this->exists
            ? $this->getHashIdRepository()->idToHash($this->getKey(), $this->getHashKey())
            : null;
    }
}
