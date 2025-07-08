<?php

namespace App\Concerns\Base;

use App\Models\Base\Address;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @property Address|null $address
 * @property Collection<Address|null> $addresses
 */
trait InteractWithAddress
{
    /**
     * Booting Method
     *
     * @return void
     */
    public static function bootInteractWithAddress(): void
    {
        //
    }

    /**
     * @return MorphOne
     */
    public function address(): MorphOne
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    /**
     * @return MorphMany
     */
    public function addresses(): MorphMany
    {
        return $this->morphMany(Address::class, 'addressable');
    }
}
