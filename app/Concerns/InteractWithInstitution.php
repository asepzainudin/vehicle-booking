<?php

namespace App\Concerns;

use App\Models\Institution;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait InteractWithInstitution
{
    /**
     * @param  Builder  $query
     * @param  string|int  $institutionId
     *
     * @return Builder
     */
    public function scopeUseInstitution(Builder $query, string|int $institutionId): Builder
    {
        if (is_string($institutionId)) {
            $institutionId = Institution::hashToId($institutionId);
        }
        return $query->where('tenant_id', $institutionId);
    }

    /**
     * @return BelongsTo
     */
    public function institution(): BelongsTo
    {
        return $this->belongsTo(Institution::class, 'tenant_id');
    }
}
