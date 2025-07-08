<?php

namespace App\Concerns\Base;

use App\Models\Base\Phone;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @property Phone|null $phone
 * @property Collection<Phone|null> $phones
 */
trait InteractWithPhone
{
    /**
     * Booting Method
     *
     * @return void
     */
    public static function bootInteractWithPhone(): void
    {
        //
    }

    /**
     * @return MorphOne
     */
    public function phone(): MorphOne
    {
        return $this->morphOne(Phone::class, 'phoneable');
    }

    /**
     * @return MorphMany
     */
    public function phones(): MorphMany
    {
        return $this->morphMany(Phone::class, 'phoneable');
    }
}
