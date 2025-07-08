<?php

namespace App\Contracts;

use App\Models\User;
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
interface HasEloquentTimestamp
{
    public function creator(): BelongsTo;

    public function updater(): BelongsTo;
}
