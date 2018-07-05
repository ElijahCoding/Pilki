<?php


namespace App\Http\Controllers\Api;

use Cache;
use App\Exceptions\Api\UnknownException;
use App\Helpers\CacheKeys;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PhoneConfirmRequest;
use App\Jobs\SendSMS;


/**
 * Class PhoneController
 *
 * @resource Phone
 * @package App\Http\Controllers\Api
 */
class PhoneController extends Controller
{
    /**
     * Send confirm SMS code
     *
     * @param PhoneConfirmRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function confirm(PhoneConfirmRequest $request)
    {
        $code = str_pad(rand(0000, 9999), 4, STR_PAD_LEFT);

        Cache::put(CacheKeys::PHONE_CONFIRM_KEY . $request->phone, $code, CacheKeys::PHONE_CONFIRM_TTL);

        dispatch(new SendSMS($request->phone, trans('sms.confirm_code', [
            'code' => $code,
        ])));

        return response()->json([
            'result' => 'success',
        ]);
    }
}
