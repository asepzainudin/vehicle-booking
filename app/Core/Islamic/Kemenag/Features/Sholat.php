<?php

namespace App\Core\Islamic\Kemenag\Features;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Response;

class Sholat extends Feature
{
    protected string|null $basePath = null;

    /**
     * @param  bool  $asArray
     *
     * @return Response|array
     * @throws ConnectionException
     */
    public function getProv(bool $asArray = false): Response|array
    {
        $result = $this->http()->post('getProvsholat');
        return $asArray ? $result->json() : $result;
    }

    /**
     * @param  string|null  $provId
     * @param  bool  $asArray
     *
     * @return Response|array
     * @throws ConnectionException
     */
    public function getCity(string|null $provId = null, bool $asArray = false): Response|array
    {
        $result = $this->http()->post('getKabkoshalat', ['x' => $provId]);
        return $asArray ? $result->json() : $result;
    }
}
