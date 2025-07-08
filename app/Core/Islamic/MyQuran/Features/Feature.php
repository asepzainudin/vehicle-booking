<?php

namespace App\Core\Islamic\MyQuran\Features;

use App\Core\Islamic\MyQuran\MyQuran;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

abstract class Feature
{
    protected string|null $basePath = null;

    protected function http(): PendingRequest
    {
        $baseUrl = str(MyQuran::$baseUrl);
        if (!empty($this->basePath)) {
            $baseUrl = $baseUrl->append('/', $this->basePath);
        }

        return Http::baseUrl($baseUrl->toString())
            ->acceptJson()
            ->withoutVerifying();
    }
}
