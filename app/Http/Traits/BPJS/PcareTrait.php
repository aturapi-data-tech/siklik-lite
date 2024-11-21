<?php

namespace App\Http\Traits\BPJS;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

use App\Http\Traits\customErrorMessagesTrait;
use Illuminate\Support\Facades\DB;


use Exception;

trait PcareTrait
{
    public function sendResponse($message, $data, $code = 200, $url, $requestTransferTime)
    {
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
    public function sendError($error, $errorMessages = [], $code = 404, $url, $requestTransferTime)
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


    // API PCARE
    public function signature()
    {
        $cons_id =  env('PCARE_CONS_ID');
        $secretKey = env('PCARE_SECRET_KEY');
        $userkey = env('PCARE_USER_KEY');


        date_default_timezone_set('UTC');
        $tStamp = strval(time() - strtotime('1970-01-01 00:00:00'));
        $signature = hash_hmac('sha256', $cons_id . "&" . $tStamp, $secretKey, true);
        $encodedSignature = base64_encode($signature);

        $response = array(
            'X-cons-id' => $cons_id,
            'X-timestamp' => $tStamp,
            'X-signature' => $encodedSignature,
            'X-authorization' => "Basic " . base64_encode(env('PCARE_USERNAME') . ':' . env('PCARE_PASSWORD') . ':' . '095'),
            'user_key' => $userkey,
            'decrypt_key' => $cons_id . $secretKey . $tStamp
        );
        return $response;
    }
    public function stringDecrypt($key, $string)
    {
        $encrypt_method = 'AES-256-CBC';
        $key_hash = hex2bin(hash('sha256', $key));
        $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);
        $output = \LZCompressor\LZString::decompressFromEncodedURIComponent($output);
        return $output;
    }

    public function response_decrypt($response, $signature, $url, $requestTransferTime)
    {
        if ($response->failed()) {
            return $this->sendError($response->reason(),  $response->json('response'), $response->status(), $url, $requestTransferTime);
        } else {
            // Check Response !200           -> metaData D besar
            $code = $response->json('metaData.code'); //code 200 -201 500 dll

            if ($code == 200 || $code == 201) {
                $decrypt = $this->stringDecrypt($signature['decrypt_key'], $response->json('response'));
                $data = json_decode($decrypt, true);
            } else {

                $data = json_decode($response, true);
            }

            return $this->sendResponse($response->json('metaData.message'), $data, $code, $url, $requestTransferTime);
        }
    }
    public function response_no_decrypt($response)
    {
        if ($response->failed()) {
            return $this->sendError($response->reason(),  $response->json('response'), $response->status(), null, null);
        } else {
            return $this->sendResponse($response->json('metaData.message'), $response->json('response'), $response->json('metaData.code'), null, null);
        }
    }







    // REFERENSI
    private function getPoliFktp($start, $end)
    {
        // customErrorMessages
        $messages = customErrorMessagesTrait::messages();

        // Masukkan Nilai dari parameter
        $r = [
            'start' => $start,
            'end' => $end,
        ];
        // lakukan validasis
        $validator = Validator::make($r, [
            "start" => "required|numeric",
            "end" => "required|numeric",
        ], $messages);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), $validator->errors()->all(), 201, null, null);
        }



        // handler when time out and off line mode
        try {

            $url = env('PCARE_URL') . "poli/fktp/" . $start . "/" . $end;
            $signature = $this->signature();
            $response = Http::timeout(10)
                ->withHeaders($signature)
                ->get($url);


            // dd($response->transferStats->getTransferTime()); Get Transfertime request
            // semua response error atau sukses dari BPJS di handle pada logic response_decrypt
            return $this->response_decrypt($response, $signature, $url, $response->transferStats->getTransferTime());
            /////////////////////////////////////////////////////////////////////////////
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), $validator->errors()->all(), 408, $url, null);
        }
    }

    private function getKesadaran()
    {
        // customErrorMessages
        $messages = customErrorMessagesTrait::messages();

        // Masukkan Nilai dari parameter
        $r = ['r' => ''];
        // lakukan validasis
        $validator = Validator::make($r, ["r" => ""], $messages);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), $validator->errors()->all(), 201, null, null);
        }



        // handler when time out and off line mode
        try {

            $url = env('PCARE_URL') . "kesadaran";
            $signature = $this->signature();
            $response = Http::timeout(10)
                ->withHeaders($signature)
                ->get($url);


            // dd($response->transferStats->getTransferTime()); Get Transfertime request
            // semua response error atau sukses dari BPJS di handle pada logic response_decrypt
            return $this->response_decrypt($response, $signature, $url, $response->transferStats->getTransferTime());
            /////////////////////////////////////////////////////////////////////////////
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), $validator->errors()->all(), 408, $url, null);
        }
    }

    private function getDokter($start, $end)
    {
        // customErrorMessages
        $messages = customErrorMessagesTrait::messages();

        // Masukkan Nilai dari parameter
        $r = [
            'start' => $start,
            'end' => $end,
        ];
        // lakukan validasis
        $validator = Validator::make($r, [
            "start" => "required|numeric",
            "end" => "required|numeric",
        ], $messages);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), $validator->errors()->all(), 201, null, null);
        }



        // handler when time out and off line mode
        try {

            $url = env('PCARE_URL') . "dokter/" . $start . "/" . $end;
            $signature = $this->signature();
            $response = Http::timeout(10)
                ->withHeaders($signature)
                ->get($url);


            // dd($response->transferStats->getTransferTime()); Get Transfertime request
            // semua response error atau sukses dari BPJS di handle pada logic response_decrypt
            return $this->response_decrypt($response, $signature, $url, $response->transferStats->getTransferTime());
            /////////////////////////////////////////////////////////////////////////////
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), $validator->errors()->all(), 408, $url, null);
        }
    }

    private function getSpesialis()
    {
        // customErrorMessages
        $messages = customErrorMessagesTrait::messages();

        // Masukkan Nilai dari parameter
        $r = ['r' => ''];
        // lakukan validasis
        $validator = Validator::make($r, ["r" => ""], $messages);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), $validator->errors()->all(), 201, null, null);
        }



        // handler when time out and off line mode
        try {

            $url = env('PCARE_URL') . "spesialis";
            $signature = $this->signature();
            $response = Http::timeout(10)
                ->withHeaders($signature)
                ->get($url);


            // dd($response->transferStats->getTransferTime()); Get Transfertime request
            // semua response error atau sukses dari BPJS di handle pada logic response_decrypt
            return $this->response_decrypt($response, $signature, $url, $response->transferStats->getTransferTime());
            /////////////////////////////////////////////////////////////////////////////
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), $validator->errors()->all(), 408, $url, null);
        }
    }

    private function getAlergi($alergi)
    {
        //parameter 1: 01:Makanan, 02:Udara, 03:Obat
        // customErrorMessages
        $messages = customErrorMessagesTrait::messages();

        // Masukkan Nilai dari parameter
        $r = ['r' => ''];
        // lakukan validasis
        $validator = Validator::make($r, ["r" => ""], $messages);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), $validator->errors()->all(), 201, null, null);
        }



        // handler when time out and off line mode
        try {

            $url = env('PCARE_URL') . "alergi/jenis/" . $alergi;
            $signature = $this->signature();
            $response = Http::timeout(10)
                ->withHeaders($signature)
                ->get($url);


            // dd($response->transferStats->getTransferTime()); Get Transfertime request
            // semua response error atau sukses dari BPJS di handle pada logic response_decrypt
            return $this->response_decrypt($response, $signature, $url, $response->transferStats->getTransferTime());
            /////////////////////////////////////////////////////////////////////////////
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), $validator->errors()->all(), 408, $url, null);
        }
    }

    private function getPrognosa()
    {
        // customErrorMessages
        $messages = customErrorMessagesTrait::messages();

        // Masukkan Nilai dari parameter
        $r = ['r' => ''];
        // lakukan validasis
        $validator = Validator::make($r, ["r" => ""], $messages);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), $validator->errors()->all(), 201, null, null);
        }



        // handler when time out and off line mode
        try {

            $url = env('PCARE_URL') . "prognosa";
            $signature = $this->signature();
            $response = Http::timeout(10)
                ->withHeaders($signature)
                ->get($url);


            // dd($response->transferStats->getTransferTime()); Get Transfertime request
            // semua response error atau sukses dari BPJS di handle pada logic response_decrypt
            return $this->response_decrypt($response, $signature, $url, $response->transferStats->getTransferTime());
            /////////////////////////////////////////////////////////////////////////////
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), $validator->errors()->all(), 408, $url, null);
        }
    }

    private function getStatusPulang($statusInap)
    {
        // customErrorMessages
        $messages = customErrorMessagesTrait::messages();

        // Masukkan Nilai dari parameter
        $r = ['statusInap' => $statusInap];
        // lakukan validasis
        $validator = Validator::make($r, ["statusInap" => "required|boolean"], $messages);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), $validator->errors()->all(), 201, null, null);
        }



        // handler when time out and off line mode
        try {
            $myStatusInap = $statusInap ? 'true' : 'false';
            $url = env('PCARE_URL') . "statuspulang/rawatInap/" . $myStatusInap;
            $signature = $this->signature();
            $response = Http::timeout(10)
                ->withHeaders($signature)
                ->get($url);


            // dd($response->transferStats->getTransferTime()); Get Transfertime request
            // semua response error atau sukses dari BPJS di handle pada logic response_decrypt
            return $this->response_decrypt($response, $signature, $url, $response->transferStats->getTransferTime());
            /////////////////////////////////////////////////////////////////////////////
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), $validator->errors()->all(), 408, $url, null);
        }
    }

    // Get Peserta
    private function getPesertabyJenisKartu($jenisKartu, $nikNoka)
    {
        // customErrorMessages
        $messages = customErrorMessagesTrait::messages();

        // Masukkan Nilai dari parameter
        $r = [
            'jenisKartu' => $jenisKartu,
            'nikNoka' => $nikNoka,
        ];
        // lakukan validasis
        $validator = Validator::make($r, [
            "jenisKartu" => "required",
            "nikNoka" => "required|min:11|max:16",
        ], $messages);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), $validator->errors()->all(), 201, null, null);
        }



        // handler when time out and off line mode
        try {

            $url = env('PCARE_URL') . "peserta/" . $jenisKartu . "/" . $nikNoka;
            $signature = $this->signature();
            $response = Http::timeout(10)
                ->withHeaders($signature)
                ->get($url);


            // dd($response->transferStats->getTransferTime()); Get Transfertime request
            // semua response error atau sukses dari BPJS di handle pada logic response_decrypt
            return $this->response_decrypt($response, $signature, $url, $response->transferStats->getTransferTime());
            /////////////////////////////////////////////////////////////////////////////
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), $validator->errors()->all(), 408, $url, null);
        }
    }




    // PENDAFTARAN
    private function addPedaftaran(array $data = [])
    {
        //parameter 1: 01:Makanan, 02:Udara, 03:Obat
        // customErrorMessages
        $messages = customErrorMessagesTrait::messages();

        // Masukkan Nilai dari parameter
        $r = $data;
        $rules = [
            "kdProviderPeserta" => "bail|required",
            "tglDaftar" => "bail|required|date_format:d-m-Y",
            "noKartu" => "bail|required|digits:13",
            "kdPoli" => "bail|required",
            "keluhan" => "bail|required",
            "kunjSakit" => "bail|required",
            "sistole" => "bail|required|numeric",
            "diastole" => "bail|required|numeric",
            "beratBadan" => "bail|required|numeric",
            "tinggiBadan" => "bail|required|numeric",
            "respRate" => "bail|required|numeric",
            "lingkarPerut" => "bail|required|numeric",
            "heartRate" => "bail|required|numeric",
            "rujukBalik" => "bail|required",
            "kdTkp" => "bail|required"
        ];
        // lakukan validasis
        $validator = Validator::make($r, $rules, $messages);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), $validator->errors()->all(), 400, null, null);
        }



        // handler when time out and off line mode
        try {

            $url = env('PCARE_URL') . "pendaftaran";
            $signature = $this->signature();
            $signature['Content-Type'] = 'text/plain';
            $response = Http::timeout(10)
                ->withHeaders($signature)
                ->post($url, $r);


            // dd($response->getBody()->getContents()); //Get Transfertime request
            // semua response error atau sukses dari BPJS di handle pada logic response_decrypt
            return $this->response_decrypt($response, $signature, $url, $response->transferStats->getTransferTime());
            /////////////////////////////////////////////////////////////////////////////
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), $validator->errors()->all(), 408, $url, null);
        }
    }

    private function deletePedaftaran($noKartu, $tglDaftar, $noUrut, $kdPoli)
    {
        // customErrorMessages
        $messages = customErrorMessagesTrait::messages();

        // Masukkan Nilai dari parameter
        $r = [
            "noKartu" => $noKartu,
            "tglDaftar" => $tglDaftar,
            "noUrut" => $noUrut,
            "kdPoli" => $kdPoli,
        ];
        $rules = [
            "noKartu" => "bail|required|digits:13",
            "tglDaftar" => "bail|required|date_format:d-m-Y",
            "noUrut" => "bail|required",
            "kdPoli" => "bail|required",
        ];
        // lakukan validasis
        $validator = Validator::make($r, $rules, $messages);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), $validator->errors()->all(), 201, null, null);
        }



        // handler when time out and off line mode
        try {

            $url = env('PCARE_URL') . "pendaftaran";
            $signature = $this->signature();
            $signature['Content-Type'] = 'text/plain';
            $response = Http::timeout(10)
                ->withHeaders($signature)
                ->post($url, $r);


            // semua response error atau sukses dari BPJS di handle pada logic response_decrypt
            return $this->response_decrypt($response, $signature, $url, $response->transferStats->getTransferTime());
            /////////////////////////////////////////////////////////////////////////////
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), $validator->errors()->all(), 408, $url, null);
        }
    }

    private function getPendaftaranbyNomorUrut($noUrut, $tglDaftar)
    {
        // customErrorMessages
        $messages = customErrorMessagesTrait::messages();

        // Masukkan Nilai dari parameter
        $r = [
            "noUrut" => $noUrut,
            "tglDaftar" => $tglDaftar,
        ];
        $rules = [
            "noUrut" => "bail|required",
            "tglDaftar" => "bail|required|date_format:d-m-Y",
        ];
        // lakukan validasis
        $validator = Validator::make($r, $rules, $messages);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), $validator->errors()->all(), 201, null, null);
        }



        // handler when time out and off line mode
        try {

            $url = env('PCARE_URL') . "pendaftaran/noUrut/" . $noUrut . "/tglDaftar/" . $tglDaftar;
            $signature = $this->signature();
            $response = Http::timeout(10)
                ->withHeaders($signature)
                ->get($url);


            // semua response error atau sukses dari BPJS di handle pada logic response_decrypt
            return $this->response_decrypt($response, $signature, $url, $response->transferStats->getTransferTime());
            /////////////////////////////////////////////////////////////////////////////
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), $validator->errors()->all(), 408, $url, null);
        }
    }

    private function getPendaftaranProvider($tglDaftar, $start, $end)
    {
        // customErrorMessages
        $messages = customErrorMessagesTrait::messages();

        // Masukkan Nilai dari parameter
        $r = [
            "tglDaftar" => $tglDaftar,
            'start' => $start,
            'end' => $end,
        ];
        $rules = [
            "tglDaftar" => "bail|required|date_format:d-m-Y",
            "start" => "required|numeric",
            "end" => "required|numeric",
        ];
        // lakukan validasis
        $validator = Validator::make($r, $rules, $messages);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), $validator->errors()->all(), 201, null, null);
        }



        // handler when time out and off line mode
        try {

            $url = env('PCARE_URL') . "/pendaftaran/tglDaftar/" . $tglDaftar . "/" . $start . "/" . $end;
            $signature = $this->signature();
            $response = Http::timeout(10)
                ->withHeaders($signature)
                ->get($url);


            // semua response error atau sukses dari BPJS di handle pada logic response_decrypt
            return $this->response_decrypt($response, $signature, $url, $response->transferStats->getTransferTime());
            /////////////////////////////////////////////////////////////////////////////
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), $validator->errors()->all(), 408, $url, null);
        }
    }
}
