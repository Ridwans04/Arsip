<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Util extends Controller
{
    // function sendNotification($pin)
    // {
    //     $data = DB::connection("sdm")->table("tbl_user")->where("pin_absen", '=', $pin)->where("email", "like", "%@raudlatuljannah%")->first();
    //     if (!is_null($data) && $data->token_aljannah != '') {
    //         foreach (explode(',', $data->token_aljannah) as $key => $value) {
    //             $curl = curl_init();
    //             $field = '{
    //                         "to":"token",
    //                         "notification": {
    //                             "body": "Alhamdulillah, Anda Berhasil Absen",
    //                             "title": "Assalamualaikum",
    //                             "icon": "https://ppdb.raudlatuljannah.com/template/dist/assets/images/logo.png"
    //                         }
    //                     }';
    //             $fields = str_replace("token", "$value", $field);
    //             curl_setopt_array($curl, array(
    //                 CURLOPT_URL => 'https://fcm.googleapis.com/fcm/send',
    //                 CURLOPT_RETURNTRANSFER => true,
    //                 CURLOPT_ENCODING => '',
    //                 CURLOPT_MAXREDIRS => 10,
    //                 CURLOPT_TIMEOUT => 0,
    //                 CURLOPT_FOLLOWLOCATION => true,
    //                 CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //                 CURLOPT_CUSTOMREQUEST => 'POST',
    //                 CURLOPT_POSTFIELDS => $fields,
    //                 CURLOPT_HTTPHEADER => array(
    //                     'Authorization: key=' . env('FIREBASE_SERVER_KEY'),
    //                     'Content-Type: application/json'
    //                 ),
    //             ));
    //             $response = curl_exec($curl);
    //             curl_close($curl);
    //         }
    //     }
    // }

    function sendNotification($pin, $date)
    {
        $db_key = DB::connection('backend')
            ->table('credentials')
            ->where('name', '=', 'aljannah_firebase_key')
            ->first();
        $key_aljannah = $db_key->value;
        $data = DB::connection("sdm")
            ->table("tbl_user")
            ->where("pin_absen", '=', $pin)
            ->where("email", "like", "%@raudlatuljannah%")
            ->first();
        if (!is_null($data) && $data->token_aljannah != '') {
            $token = explode(',', $data->token_aljannah);
            $jumlah = count($token);
            $dataToken = [];
            if ($jumlah > 0) {
                if ($token[0] != '') {
                    array_push($dataToken, $token[0]);
                }
            }
            if ($jumlah > 1) {
                if ($token[1] != '') {
                    array_push($dataToken, $token[1]);
                }
            }
            foreach ($dataToken as $key => $value) {
                $curl = curl_init();
                $format_date = date('h:i d M Y', strtotime($date));
                $msg = "Alhamdulillah, Anda Berhasil Absen Pada " . $format_date;
                $title = "Assalamualaikum";
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://fcm.googleapis.com/v1/projects/aljannah-408505/messages:send',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => json_encode(
                        [
                            "message" => [
                                "token" => $value,
                                "notification" => [
                                    "body" => $msg,
                                    "title" => $title
                                ]
                            ]
                        ]
                    ),
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: Bearer ' . $key_aljannah,
                        'Content-Type: application/json'
                    ),
                ));
                $response = curl_exec($curl);
                curl_close($curl);
            }
        }
    }

    public function getattendance(Request $request)
    {
        $req_date = $request->date ?? date('Y-m-d H:i:s');
        $date = date('Y-m-d H:i:s', strtotime($req_date));
        $datas = DB::connection('absensi')
            ->table('checkinout')->select(['checkinout.SN', 'checkinout.checktype', 'checkinout.verifycode', 'checkinout.checktime', 'userinfo.badgenumber'])
            ->join('userinfo', 'userinfo.userid', '=', 'checkinout.userid')
            ->where('created_at', '>=', $date);
        if ($request->has('end_date')) {
            $end_date = date('Y-m-d H:i:s', strtotime($request->end_date));
            $datas->where('created_at', '<=', $end_date);
        }
        $data = $datas->get()->toArray();

        // return response()->json(['status' => '200', 'data' => $data], 200);
        foreach ($data as $key => $value) {
            $pin = (int)$value->badgenumber;
            $datetime = $value->checktime;
            $format = date('Y-m-d h:i', strtotime($datetime));
            $status = $value->checktype;
            $verifyType = $value->verifycode;
            $no_mesin = $value->SN;
            try {
                DB::connection('sdm')->table('absen')->insert([
                    'id' => $format . $pin . '.' . $status . $verifyType,
                    'pin' => $pin,
                    'waktu' => $datetime,
                    'status' => $status,
                    'mesin' => $no_mesin,
                    'verifikasi' => $verifyType,
                ]);
                $this->sendNotification($pin, $datetime);
            } catch (\Throwable $th) {
            }
        }
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }

    public function getattendancebychecktime(Request $request)
    {
        $req_date = $request->date ?? date('Y-m-d H:i:s');
        $date = date('Y-m-d H:i:s', strtotime($req_date));
        $datas = DB::connection('absensi')
            ->table('checkinout')->select(['checkinout.SN', 'checkinout.checktype', 'checkinout.verifycode', 'checkinout.checktime', 'userinfo.badgenumber'])
            ->join('userinfo', 'userinfo.userid', '=', 'checkinout.userid')
            ->where('checkinout.checktime', '>', $date);
        if ($request->has('enddate')) {
            $enddate = date('Y-m-d H:i:s', strtotime($request->enddate));
            $datas->where('checkinout.checktime', '<', $enddate);
        }
        $data = $datas->get()->toArray();

        // return response()->json(['status' => '200', 'data' => $data], 200);
        foreach ($data as $key => $value) {
            $pin = (int)$value->badgenumber;
            $datetime = $value->checktime;
            $format = date('Y-m-d h:i', strtotime($datetime));
            $status = $value->checktype;
            $verifyType = $value->verifycode;
            $no_mesin = $value->SN;
            try {
                DB::connection('sdm')->table('absen')->insert([
                    'id' => $format . $pin . '.' . $status . $verifyType,
                    'pin' => $pin,
                    'waktu' => $datetime,
                    'status' => $status,
                    'mesin' => $no_mesin,
                    'verifikasi' => $verifyType,
                ]);
                $this->sendNotification($pin, $datetime);
            } catch (\Throwable $th) {
            }
        }
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }
}
