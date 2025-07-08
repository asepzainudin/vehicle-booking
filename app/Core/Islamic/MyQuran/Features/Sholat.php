<?php

namespace App\Core\Islamic\MyQuran\Features;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Response;

class Sholat extends Feature
{
    protected string|null $basePath = 'sholat';

    /**
     * @param  int|string|null  $key
     * @param  bool  $asArray
     *
     * @return Response|array
     * @throws ConnectionException
     */
    public function getCity(int|string|null $key = null, bool $asArray = false): Response|array
    {
        $path = 'kota';
        if ($key) {
            $path .= is_numeric($key)
                ? '/'.$key
                : '/cari/'.$key;
        } else {
            $path .= '/semua';
        }
        $result = $this->http()->get($path);
        return $asArray ? $result->json() : $result;
    }

    /**
     * @param  string|null  $city
     * @param  string|null  $year
     * @param  string|null  $month
     * @param  string|null  $day
     * @param  bool  $asArray
     *
     * @return Response|array
     * @throws ConnectionException
     */
    public function getTimes(
        string|null $city = null,
        string|null $year = null,
        string|null $month = null,
        string|null $day = null,
        bool $asArray = false
    ): Response|array {
        $year ??= date('Y');
        $month ??= date('m');

        $path = "jadwal/{$city}/{$year}/{$month}";
        if ($day) {
            $path .= '/'.$day;
        }
        $result = $this->http()->get($path);
        return $asArray ? $result->json() : $result;
    }
}
