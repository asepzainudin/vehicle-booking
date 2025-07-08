<?php

namespace App\ModelRules\Dataset;

use App\ModelRules\ModelRule;

class BankMdRule extends ModelRule
{
    public function __construct(
        public bool $activeOnly = true,
        public bool $withTrashed = false
    ) {
        //
    }
}
