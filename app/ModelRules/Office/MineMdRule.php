<?php

namespace App\ModelRules\Office;

use App\ModelRules\ModelRule;

class MineMdRule extends ModelRule
{
    public function __construct(
        public bool $activeOnly = true,
        public bool $withTrashed = false
    ) {
        //
    }
}
