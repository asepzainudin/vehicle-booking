<?php

namespace App\Vendor\MediaLibrary\MediaCollections\Models;

use App\Concerns\Partner\InteractWithPartner;
use App\Contracts\Partner\HasPartner;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Media extends \Spatie\MediaLibrary\MediaCollections\Models\Media implements HasPartner
{
    use HasUuids;
    use InteractWithPartner;

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

}
