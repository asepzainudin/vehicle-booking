<?php

namespace App\Contracts;

use App\Models\Institution;
use Illuminate\Database\Eloquent\Builder;

/**
 * @property Institution $institution
 *
 * @method Builder useInstitution(string|int $institutionId)
 */
interface HasInstitution
{
    //
}
