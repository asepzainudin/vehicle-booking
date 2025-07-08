<?php

namespace App\ModelRules\UserManagement;

use App\ModelRules\ModelRule;

class PartnerMdRule extends ModelRule
{
    public function __construct(
        public bool $activeOnly = true,
        public bool $withTrashed = false
    ) {
        //
    }
}
