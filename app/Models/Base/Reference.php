<?php

namespace App\Models\Base;

use App\Contracts\Base\HasReference;
use App\Models\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reference extends Model implements HasReference
{
    use SoftDeletes;
    use HasUuids;

    /** @inheritdoc */
    protected $table = 'references';

    /** @inheritdoc */
    protected $fillable = [
        'refable_type', 'refable_id', 'refable_uuid',
        'value', 'complex',
    ];

    //== Accessor - Mutator

    protected function casts(): array
    {
        return [
            'complex' => 'array',
        ];
    }

    //== Relationships

    //== Methods
}
