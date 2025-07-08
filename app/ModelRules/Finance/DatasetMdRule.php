<?php

namespace App\ModelRules\Finance;

use App\ModelRules\ModelRule;

class DatasetMdRule extends ModelRule
{
    public function __construct(
        public bool $activeOnly = true,
        public bool $withTrashed = false
    ) {
        //
    }
}
