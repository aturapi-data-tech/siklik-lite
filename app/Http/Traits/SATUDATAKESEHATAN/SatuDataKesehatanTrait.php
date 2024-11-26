<?php

namespace App\Http\Traits\SATUDATAKESEHATAN;

use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use Exception;

trait SatuDataKesehatanTrait
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
            'date_ref' => Carbon::now(env('APP_TIMEZONE')),
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
            'date_ref' => Carbon::now(env('APP_TIMEZONE')),
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


    // DINKESTA (SATU DATA KESEHATAN TUUNGAGUNG)
    // auth
    // //////////
    // //////////


    // API DINKESTULUNGAGUNG
    public static function signature()
    {
        $xusername =  env('DINKESTULUNGAGUNG_XUSERNAME');
        $xpassword = env('DINKESTULUNGAGUNG_XPASSWORD');


        $header = json_encode(['user' => $xusername, 'pass' => $xpassword]);
        $tStamp = strval(time() - strtotime('1970-01-01 00:00:00'));
        $payload = json_encode(['user_id' => $xusername, 'tStamp' => $tStamp]);
        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, 'ab123', true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
        $token = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;

        $response = array(
            'x-username' => $xusername,
            'x-password' => $xpassword,
            'x-token' => $token,
        );
        return $response;
    }
    // auth
    // //////////
    // //////////


    // API PUSH
    public static function PostPortalSatuDataTulungagung($dataDiagnosisRJ)
    {
        // customErrorMessages
        // $messages = customErrorMessagesTrait::messages();
        $messages = [];

        // Masukkan Nilai dari parameter

        $r = [
            "tanggal" => $dataDiagnosisRJ['tanggal'],
            "nik" => $dataDiagnosisRJ['nik'],
            "nama" => $dataDiagnosisRJ['nama'],
            "alamat" => $dataDiagnosisRJ['alamat'],
            "desa" => $dataDiagnosisRJ['desa'],
            "kecamatan" => $dataDiagnosisRJ['desa'],
            "icdx" => $dataDiagnosisRJ['icdx'],
            "kunjungan" => $dataDiagnosisRJ['kunjungan'],
            "kasus" => $dataDiagnosisRJ['kasus'],
        ];

        $validator = Validator::make($r, [
            "tanggal" => 'required',
            "nik" => 'required',
            "nama" => 'required',
            "alamat" => 'required',
            "desa" => 'required',
            "kecamatan" => 'required',
            "icdx" => 'required',
            "kunjungan" => 'required',
            "kasus" => 'required',

        ], $messages);

        $url = env('DINKESTULUNGAGUNG_URL');


        if ($validator->fails()) {
            return self::prosesResponse($validator->errors()->first(), json_decode($validator->errors(), true), 201, $url, null);
        }


        try {

            // $headers = self::signature();
            $signature = self::signature();
            $signature['Content-Type'] = 'application/json';
            $data = $r;


            $response = Http::timeout(10)
                ->withHeaders($signature)
                ->post($url, $data);

            $myResponse = [$response->getBody()->getContents()];
            $myResponseJson = json_encode($myResponse, true);

            return self::prosesResponse($myResponseJson, $myResponse, $response->status(), $url, $response->transferStats->getTransferTime());
        } catch (Exception $e) {
            return self::prosesResponse($e->getMessage(), [], 408, $url, null);
        }
    }
}
