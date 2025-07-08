<?php

namespace App\Core\Islamic\Kemenag;

use App\Core\Islamic\Kemenag\Features\Sholat;

class Kemenag
{
    public static $baseUrl = 'https://bimasislam.kemenag.go.id/ajax';

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
