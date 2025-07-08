<?php

namespace App\Core\Notification\Drivers;

use App\Core\Notification\Concerns\HasLog;
use Exception;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Psr\Http\Message\RequestInterface;
use Throwable;

abstract class NotificationDriver
{
    use HasLog;

    protected PendingRequest|null $client = null;

    public bool $isGroup = false;
    public bool $isSuccess = false;
    public string|null $requestEndpoint = null;
    public string $responseId = '00';
    public string $responseCode = '00';
    public string $responseStatus = '';
    public string $responseMessage = '';

    public string $createdAt = '';
    public array $rawResponse = [];

    protected bool $asAsync = false;

    /**
     * @param  string  $baseUrl
     * @param  array|null  $options
     *
     * @return void
     * @throws Exception
     */
    protected function setClient(string $baseUrl, array|null $options = []): void
    {
        if (!$options) {
            $options = [];
        }

        try {
            $this->client = Http::baseUrl($baseUrl)
                // ->withoutVerifying()
                // ->withoutRedirecting()
                // ->timeout(180)
                ->withOptions(array_merge([
                    'verify' => false,
                    'allow_redirects' => false,
                    'timeout' => 180,   // 3 minutes
                    'debug' => false,
                ], $options))
                ->withRequestMiddleware(function (RequestInterface $request) {
                    $uri = $request->getUri();
                    $reqHost = $uri->getHost();
                    $reqPathWithQuery = $request->getRequestTarget();
                    $reqScheme = $uri->getScheme();
                    $this->requestEndpoint = $reqScheme.'://'.$reqHost.$reqPathWithQuery;

                    return $request;
                });
        } catch (Throwable $e) {
            $this->client = null;
        }
        $this->onClient();
    }

    /**
     * @return void
     * @throws Exception
     */
    protected function onClient(): void
    {
        if (! $this->client) {
            throw new Exception('http client not set', 500);
        }
    }

    /**
     * @param  bool  $sync
     *
     * @return $this
     */
    public function sync(bool $sync = true): static
    {
        $this->asAsync = ! $sync;
        return $this;
    }

    /**
     * @return $this
     */
    public function async(): static
    {
        $this->asAsync = true;
        return $this;
    }

    /**
     * @param array $params
     * @param bool $isGroup
     * @return bool
     */
    abstract public function send(array $params = [], bool $isGroup = false): bool;

    /**
     * @param ...$arg
     *
     * @return void
     * @throws Exception
     */
    protected function requiredAll(...$arg): void
    {
        $invalid = collect($arg)->filter(fn ($a) => empty($a));
        if ($invalid->isNotEmpty()) {
            static::logError('invalid params', ['params' => $invalid->all()]);
            throw new Exception('invalid param', 400);
        }
    }
}
