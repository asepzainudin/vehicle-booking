<?php

namespace App\Concerns\Base;

use App\Models\Base\Email;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @property Email|null $email
 * @property Collection<Email|null> $emails
 */
trait InteractWithEmail
{
    /**
     * Booting Method
     *
     * @return void
     */
    public static function bootInteractWithEmail(): void
    {
        //
    }

    /**
     * @return MorphOne
     */
    public function email(): MorphOne
    {
        return $this->morphOne(Email::class, 'emailable');
    }

    /**
     * @return MorphMany
     */
    public function emails(): MorphMany
    {
        return $this->morphMany(Email::class, 'emailable');
    }
}
