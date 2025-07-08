<?php

namespace App\ModelRules\Finance;

use App\ModelRules\ModelRule;

class TransferMdRule extends ModelRule
{
    public function __construct(
        public bool $activeOnly = true,
        public bool $withTrashed = false
    ) {
        //
    }
}
