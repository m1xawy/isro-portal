<?php

namespace App\Helpers\Donate\MaxiCard;


use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MaxiCardApiHelper
{

    /**
     * @param $code
     * @param $password
     * @return false|JsonResponse
     * @throws Exception
     */
    public static function sendMaxiCardPostRequest($code, $password)
    {
        //check whether user is logged in or not
        if (!Auth::check()) {
            return response()->json(['error' => "You're not logged in."], 403);
        }

        //get user
        $user = Auth::user();

        //set api key and password
        $api_key = config('maxicard.key', '');
        $api_password = config('maxicard.password', '');

        //set xml data
        $xml = "<APIRequest>
                    <params>
                        <username>{$api_key}</username>
                        <password>{$api_password}</password>
                        <cmd>epinadd</cmd>
                        <epinusername>{$user->jid}</epinusername>
                        <epincode>{$code}</epincode>
                        <epinpass>{$password}</epinpass>
                    </params>
                </APIRequest>";

        $request = Http::send('post', "https://www.maxigame.org/epin/yukle.php", [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                "Cache-Control" => "no-cache",
            ],
            'form_params' => [
                'data' => urlencode($xml)
            ],
        ]);

        Log::info($request);

        //return data
        return simplexml_load_string($request->body());
    }
}
