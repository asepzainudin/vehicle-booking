<?php

namespace App\Contracts\Partner;

use App\Enums\ActionType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method Builder usePartner(string|int $partnerId, bool $allowNull = false)
 */
interface HasPartner
{
    /**
     * @return string
     */
    public static function partnerKey(): string;

    /**
     * @param  Builder  $query
     * @param  string|int  $partnerId
     * @param  bool  $allowNull
     * @param  string|null  $key
     *
     * @return void
     */
    public function scopeUsePartner(Builder $query, string|int $partnerId, bool $allowNull = false, string|null $key = null): void;

    /**
     * @param  Builder  $query
     * @param  string|array|null  $action
     *
     * @return void
     */
    public function scopeWithoutAction(Builder $query, string|array|null $action = null): void;

    /**
     * @return BelongsTo
     */
    public function partner(): BelongsTo;

    /**
     * @return HasMany
     */
    public function partners(): HasMany;

    /**
     * @param  ActionType  $action
     *
     * @return bool
     */
    public function doAction(ActionType $action): bool;
}
