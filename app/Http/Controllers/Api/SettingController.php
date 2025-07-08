<?php

namespace App\Http\Controllers\Api;

use App\Models\Base\Setting;
use Exception;
use Illuminate\Http\Request;
use Kfn\Base\Enums\ResponseCode;
use Kfn\Base\Exceptions\KfnException;
use Kfn\Base\Response;

class SettingController extends Controller
{
    public function patch(Request $request): Response
    {
        $request->validate([
            'key' => 'required|string',
            'column' => 'required|string|in:value,values,complex',
            'value' => 'required',
        ]);

        if ($request->has('need_eror')) {
            throw new KfnException(ResponseCode::ERR_ENTITY_NOT_FOUND, 'Maaf saya perlu error');
        }

        $column = $request->input('column');
        if ($column === 'values') {
            $column = 'complex';
        }

        try {
            Setting::query()
                ->where('key', $request->get('key'))
                ->update([
                    $column => $request->input('value'),
                ]);
            $message = 'Data berhasil di perbarui';
        } catch (Exception $e) {
            $message = 'Data gagal di perbarui';
        }

        return $this->response(message: $message);
    }
}
