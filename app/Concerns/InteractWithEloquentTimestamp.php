<?php

namespace App\Concerns;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property Carbon|null $created_at
 * @property int|null $created_by
 * @property User|null $creator
 * @property Carbon|null $updated_at
 * @property int|null $updated_by
 * @property User|null $updater
 */
trait InteractWithEloquentTimestamp
{
    use HasRelationships;

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
