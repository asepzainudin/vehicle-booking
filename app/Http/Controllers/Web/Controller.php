<?php

namespace App\Http\Controllers\Web;

use Kfn\UI\Concerns\HasUI;

abstract class Controller extends \App\Http\Controllers\Controller
{
    use HasUI;

    public function __construct()
    {
        parent::__construct();
    }
}
