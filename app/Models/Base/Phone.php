<?php

namespace App\Models\Base;

use App\Contracts\Base\UsingPhone;
use App\Models\Model;
use App\Vendor\LaravelHashId\Eloquent\HashableId;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Phone extends Model implements UsingPhone
{
    use SoftDeletes;
    use HashableId;

    /** @var bool */
    protected bool $shouldHashPersist = true;

    /** @inheritdoc */
    protected $table = 'phones';

    /** @inheritdoc */
    protected $fillable = [
        'model_type', 'model_id',
        'is_primary', 'name', 'dial_code', 'phone',
    ];

    //== Relationships
    public function phoneable(): MorphTo
    {
        return $this->morphTo('phoneable', 'model_type', 'model_id');
    }

    //== Methods
}
