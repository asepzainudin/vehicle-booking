<?php

namespace App\Contracts\Base;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

interface HasPhone extends UsingPhone
{
    /**
     * @return MorphOne
     */
    public function phone(): MorphOne;

    /**
     * @return MorphMany
     */
    public function phones(): MorphMany;
}
