<?php

namespace App\Http\Traits\BPJS;

use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use Exception;

trait SatuSehatTrait
{

    private static function sendResponse(string $message = 'OK', array $data = [], $code = 200, string $url = '', $requestTransferTime)
    {
        //
        $response = [
            'response' => $data,
            'metadata' => [
                'message' => $message,
                'code' => $code,
            ],
        ];

        // Insert webLogStatus
        DB::table('web_log_status')->insert([
            'code' =>  $code,
            'date_ref' => Carbon::now(),
            'response' => json_encode($response, true),
            'http_req' => $url,
            'requestTransferTime' => $requestTransferTime
        ]);

        return response()->json($response, $code);
    }

    private static function sendError(string $error = 'NOT OK', array $errorMessages = [], $code = 404, string $url = '', $requestTransferTime)
    {
        $response = [
            'metadata' => [
                'message' => $error,
                'code' => $code,
            ],
        ];
        if (!empty($errorMessages)) {
            $response['response'] = $errorMessages;
        }
        // Insert webLogStatus
        DB::table('web_log_status')->insert([
            'code' =>  $code,
            'date_ref' => Carbon::now(),
            'response' => json_encode($response, true),
            'http_req' => $url,
            'requestTransferTime' => $requestTransferTime
        ]);

        return response()->json($response, $code);
    }

    private static function prosesResponse(string $message = '', array $myResponse = [], $status = 404, string $url = '', $getTransferTime)
    {
        if ($status == 200) {
            return self::sendResponse($message, $myResponse, $status, $url, $getTransferTime);
        } else {
            return self::sendError($message, $myResponse, $status, $url, $getTransferTime);
        }
    }

    public static function signature()
    {
        $headers = ['Content-Type' => 'application/x-www-form-urlencoded'];
        return $headers;
    }







    // SATUSEHAT
    // auth
    // //////////
    // //////////


    private static function OAuth2()
    {
        $clientId =  env('SATUSEHAT_CLIENT_ID');
        $secretId = env('SATUSEHAT_SECRET_ID');
        $headers = self::signature();

        $url = env('SATUSEHAT_AUTH_URL') . "accesstoken?grant_type=client_credentials";
        try {

            $response = Http::timeout(10)
                ->withHeaders($headers)
                ->send('POST', $url, [
                    'form_params' => [
                        'client_id' => $clientId,
                        'client_secret' => $secretId
                    ]
                ]);
            $myResponse = json_decode($response->getBody()->getContents(), true);
            $myResponseJson = json_encode($myResponse, true);
            return self::prosesResponse($myResponseJson, $myResponse, $response->status(), $url, $response->transferStats->getTransferTime());
        } catch (Exception $e) {
            return self::prosesResponse($e->getMessage(), [], 408, $url, null);
        }
    }

    private static function access_token(): string
    {
        $access_token = self::OAuth2()->getOriginalContent();
        if ($access_token['metadata']['code'] == 200) {
            return $access_token['response']['access_token'];
        }
        return '';
    }
    // auth
    // //////////
    // //////////


    // API

    // pasien by nik
    public static function PatientByNIK($nik)
    {
        $access_token = self::access_token();

        $url = env('SATUSEHAT_BASE_URL') . "Patient?identifier=https://fhir.kemkes.go.id/id/nik|" . $nik;
        try {

            // $headers = self::signature();
            $headers['Authorization'] = 'Bearer ' . $access_token;


            $response = Http::timeout(10)
                ->withHeaders($headers)
                ->send(
                    'GET',
                    $url
                );
            $myResponse = json_decode($response->getBody()->getContents(), true);
            $myResponseJson = json_encode($myResponse, true);
            return self::prosesResponse($myResponseJson, $myResponse, $response->status(), $url, $response->transferStats->getTransferTime());
        } catch (Exception $e) {
            return self::prosesResponse($e->getMessage(), [], 408, $url, null);
        }
    }

    // nakes by nik
    public static function PractitionerByNIK($nik)
    {
        $access_token = self::access_token();

        $url = env('SATUSEHAT_BASE_URL') . "Practitioner?identifier=https://fhir.kemkes.go.id/id/nik|" . $nik;
        try {

            // $headers = self::signature();
            $headers['Authorization'] = 'Bearer ' . $access_token;


            $response = Http::timeout(10)
                ->withHeaders($headers)
                ->send(
                    'GET',
                    $url
                );
            $myResponse = json_decode($response->getBody()->getContents(), true);
            $myResponseJson = json_encode($myResponse, true);
            return self::prosesResponse($myResponseJson, $myResponse, $response->status(), $url, $response->transferStats->getTransferTime());
        } catch (Exception $e) {
            return self::prosesResponse($e->getMessage(), [], 408, $url, null);
        }
    }

    // nakes Location
    public static function getLocation($poliDesc)
    {
        $access_token = self::access_token();

        $url = env('SATUSEHAT_BASE_URL') . "Location?name=" . $poliDesc;
        try {

            // $headers = self::signature();
            $headers['Authorization'] = 'Bearer ' . $access_token;


            $response = Http::timeout(10)
                ->withHeaders($headers)
                ->send(
                    'GET',
                    $url
                );
            $myResponse = json_decode($response->getBody()->getContents(), true);
            $myResponseJson = json_encode($myResponse, true);
            return self::prosesResponse($myResponseJson, $myResponse, $response->status(), $url, $response->transferStats->getTransferTime());
        } catch (Exception $e) {
            return self::prosesResponse($e->getMessage(), [], 408, $url, null);
        }
    }

    public static function postLocation($Location)
    {
        $access_token = self::access_token();

        $url = env('SATUSEHAT_BASE_URL') . "Location";
        try {

            // $headers = self::signature();
            $headers['Authorization'] = 'Bearer ' . $access_token;


            $response = Http::timeout(10)
                ->withHeaders($headers)
                ->post($url, $Location);

            $myResponse = json_decode($response->getBody()->getContents(), true);
            $myResponseJson = json_encode($myResponse, true);
            return self::prosesResponse($myResponseJson, $myResponse, $response->status(), $url, $response->transferStats->getTransferTime());
        } catch (Exception $e) {
            return self::prosesResponse($e->getMessage(), [], 408, $url, null);
        }
    }

    public static function postBundleEncounterCondition($Bundle)
    {
        $access_token = self::access_token();

        $url = env('SATUSEHAT_BASE_URL');
        try {

            // $headers = self::signature();
            $headers['Authorization'] = 'Bearer ' . $access_token;


            $response = Http::timeout(10)
                ->withHeaders($headers)
                ->post($url, $Bundle);

            $myResponse = json_decode($response->getBody()->getContents(), true);
            $myResponseJson = json_encode($myResponse, true);
            return self::prosesResponse($myResponseJson, $myResponse, $response->status(), $url, $response->transferStats->getTransferTime());
        } catch (Exception $e) {
            return self::prosesResponse($e->getMessage(), [], 408, $url, null);
        }
    }
}
