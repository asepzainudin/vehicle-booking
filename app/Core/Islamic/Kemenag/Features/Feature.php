<?php

namespace App\Core\Islamic\Kemenag\Features;

use App\Core\Islamic\Kemenag\Kemenag;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

abstract class Feature
{
    protected string|null $basePath = null;

    protected function http(): PendingRequest
    {
        $baseUrl = str(Kemenag::$baseUrl);
        if (!empty($this->basePath)) {
            $baseUrl = $baseUrl->append('/', $this->basePath);
        }

        return Http::baseUrl($baseUrl->toString())
            ->acceptJson()
            ->withoutVerifying()
            ->withHeader('Origin', 'https://bimasislam.kemenag.go.id');
    }
}
