<?php

namespace App\Contracts\Base;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

interface HasAddress extends UsingAddress
{
    /**
     * @return MorphOne
     */
    public function address(): MorphOne;

    /**
     * @return MorphMany
     */
    public function addresses(): MorphMany;
}
