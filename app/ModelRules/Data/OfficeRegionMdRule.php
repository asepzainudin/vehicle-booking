<?php

namespace App\ModelRules\Data;

use App\ModelRules\ModelRule;

class OfficeRegionMdRule extends ModelRule
{
    public function __construct(
        public bool $activeOnly = true,
        public bool $withTrashed = false
    ) {
        //
    }
}
