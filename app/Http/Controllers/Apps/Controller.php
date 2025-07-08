<?php

namespace App\Http\Controllers\Apps;

use Flasher\Prime\Notification\Type;
use Kfn\UI\Concerns\HasUI;

abstract class Controller extends \App\Http\Controllers\Controller
{
    use HasUI;

    public function __construct()
    {
        parent::__construct();
    }

    protected static function flashType(bool|null $success = false): string
    {
        return $success ? Type::SUCCESS : Type::ERROR;
    }
}
