<?php

namespace App\Models\Base;

use App\Contracts\Base\UsingEmail;
use App\Models\Model;
use App\Vendor\LaravelHashId\Eloquent\HashableId;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Email extends Model implements UsingEmail
{
    use SoftDeletes;
    use HashableId;

    /** @var bool */
    protected bool $shouldHashPersist = true;

    /** @inheritdoc */
    protected $table = 'emails';

    /** @inheritdoc */
    protected $fillable = [
        'model_type', 'model_id',
        'is_primary', 'name', 'email',
    ];

    //== Relationships
    public function emailable(): MorphTo
    {
        return $this->morphTo('emailable', 'model_type', 'model_id');
    }

    //== Methods
}
