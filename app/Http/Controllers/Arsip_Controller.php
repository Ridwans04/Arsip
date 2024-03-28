<?php

namespace App\Http\Controllers;

use App\Models\Data\Arsip_Penting;
use App\Models\Data\Arsip_Umum;
use App\Models\Master\Master_Surat;
use Illuminate\Http\Request;
use App\Models\Data\Surat;

class Arsip_Controller extends Controller
{
    public function pilih_klasifikasi_surat(Request $request)
    {
        $jenis = $request->pilih_klasifikasi;
        $data = Master_Surat::where('klasifikasi', $jenis)->orderBy('id', 'desc')->get();
        return response()->json([
            'data' => $data,
            'success' => true,
        ]);
    }

    public function get_data_arsip(Request $request)
    {
        $nama_surat = $request->nama_surat;

        $klasifikasi_surat = Master_Surat::where('nama_surat', $nama_surat)->first();
        $institusi = $request->ins;

        if($klasifikasi_surat->klasifikasi == 'Penting'){
            $data = Arsip_Penting::where('nama_surat', $nama_surat)->where('institusi', $institusi)->orderBy('id', 'desc')->get();
        }
        else{
            $data = Arsip_Umum::where('nama_surat', $nama_surat)->where('institusi', $institusi)->orderBy('id', 'desc')->get();
        }

        return response()->json([
            'data' => $data,
            'success' => true,
        ]);
    }
    
    public function get_arsip_lama(Request $request)
    {
        $nama_surat = $request->nama_surat;
        $institusi = $request->ins;
        $data = Surat::where('nama_surat', $nama_surat)->where('institusi', $institusi)->orderBy('id', 'desc')->get();

        return response()->json([
            'data' => $data,
            'success' => true,
        ]);
    }

    public function cari_data_umum(Request $request)
    {
        $ins = $request->institusi;
        $name = $request->name;
        $value = $request->input('value');
        $data = Surat::where($name, 'LIKE', '%'. $value .'%')->where('institusi', $ins);

        $surat = $data->get();
        return response()->json(['data' => $surat, 'success' => true]);
    }

    public function cari_data_penting(Request $request)
    {
        $ins = $request->institusi;
        $value = $request->input('value');
        $data = Surat::where('nomor_surat', 'LIKE', '%'. $value .'%')
                    ->where('tanggal', '%'. $value .'%')
                    ->where('perihal', '%'. $value .'%')
                    ->where('institusi', $ins);

        $surat = $data->get();
        return response()->json(['data' => $surat, 'success' => true]);
    }

}
