<?php

namespace App\Contracts\Base;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

interface HasEmail extends UsingEmail
{
    /**
     * @return MorphOne
     */
    public function email(): MorphOne;

    /**
     * @return MorphMany
     */
    public function emails(): MorphMany;
}
