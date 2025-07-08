<?php

namespace App\Core\Islamic\MyQuran;

use App\Core\Islamic\MyQuran\Features\Sholat;

class MyQuran
{
    public static $baseUrl = 'https://api.myquran.com/v2';

    public function __construct(protected string $feature)
    {

    }

    public static function make(string $feature): Sholat|null
    {
        return match ($feature) {
            'sholat' => new Sholat(),
            default => null,
        };
    }
}
