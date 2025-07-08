<?php

namespace App\Http\Controllers\Api;

use Kfn\Base\Concerns\HasApi;

abstract class Controller extends \App\Http\Controllers\Controller
{
    use HasApi;

    public function __construct()
    {
        parent::__construct();
    }
}