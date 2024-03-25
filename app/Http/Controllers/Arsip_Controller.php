<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use App\Models\Disposisi;
use App\Models\Dokumen;
use App\Models\Ekspedisi;
use Illuminate\Http\Request;
use App\Models\Surat;
use Illuminate\Support\Facades\Auth;
use File;

class Arsip_Controller extends Controller
{
    public function pilih_klasifikasi_surat(Request $request)
    {
        $jenis = $request->pilih_klasifikasi;
        $data = Dokumen::where('klasifikasi', $jenis)->orderBy('id', 'desc')->get();
        return response()->json([
            'data' => $data,
            'success' => true,
        ]);
    }

    public function get_data_arsip(Request $request)
    {
        $nama_surat = $request->nama_surat;
        $institusi = $request->ins;
        $data = Surat::where('nama_surat', $nama_surat)->where('institusi', $institusi)->orderBy('id', 'desc')->get();

        return response()->json([
            'data' => $data,
            'success' => true,
        ]);
    }

    public function get_arsip_penting(Request $request)
    {
        $institusi = $request->ins;
        $data = Surat::where('klasifikasi', 'Penting')->where('institusi', $institusi)->orderBy('id', 'desc')->get();

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
