<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

abstract class ControllerApi extends Controller
{
    /**
     * class instance
     */
    public function __construct()
    {
        parent::__construct();
        //
    }

    /**
     * @param  array  $data
     * @param  int  $status
     * @param  string|null  $message
     *
     * @return JsonResponse
     */
    protected function response(array $data = [], int $status = 200, string|null $message = null): JsonResponse
    {
        $compiledData = [
            'status' => $status < 400 ? 'success' : 'failed',
            'message' => $message ?? ($status < 400 ? 'Berhasil' : 'Gagal'),
            'data' => $data,
        ];

        return response()->json($compiledData, $status);
    }
}
