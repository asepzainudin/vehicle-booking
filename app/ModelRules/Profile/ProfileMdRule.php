<?php

namespace App\ModelRules\Profile;

use App\ModelRules\ModelRule;

class ProfileMdRule extends ModelRule
{
    public function __construct(
        public bool $activeOnly = true,
        public bool $withTrashed = false
    ) {
        //
    }
}
