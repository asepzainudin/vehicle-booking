<?php

namespace App\Models\Base;

use App\Contracts\Base\UsingDefine;
use App\Models\Model;
use App\Vendor\LaravelHashId\Eloquent\HashableId;
use Illuminate\Database\Eloquent\SoftDeletes;

class Define extends Model implements UsingDefine
{
    use SoftDeletes;
    use HashableId;

    /** @var bool */
    protected bool $shouldHashPersist = true;

    /** @inheritdoc */
    protected $table = 'defines';

    /** @inheritdoc */
    protected $fillable = [
        'type', 'key', 'value',
        'options', 'is_require', 'is_active', 'sort',
    ];

    //== Accessor - Mutator

    protected function casts(): array
    {
        return [
            'options' => 'array',
        ];
    }

    //== Relationships

    //== Methods
}
