<?php

namespace App\Http\Controllers;

use App\Models\Data\Arsip_Lama;
use App\Models\Data\Arsip_Penting;
use App\Models\Data\Arsip_Umum;
use App\Models\Master\Master_Surat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Arsip_Controller extends Controller
{
    protected $arsip_lama;

    public function __construct()
    {
        $this->arsip_lama = new Arsip_Lama();
    }
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

        if ($klasifikasi_surat->klasifikasi == 'Penting') {
            $data = Arsip_Penting::where('nama_surat', $nama_surat)->where('institusi', $institusi)->orderBy('id', 'desc')->get();
        } else {
            $data = Arsip_Umum::where('nama_surat', $nama_surat)->where('institusi', $institusi)->orderBy('id', 'desc')->get();
        }

        return response()->json([
            'data' => $data,
            'success' => true,
        ]);
    }

    public function update_arsip(Request $request)
    {
        $id = $request->input('id');
        $kode = $request->input('kode');
        $masa = $request->input('masa');
        $tanggal = $request->input('tanggal');

        $data = Arsip_Umum::find($id);
        $data->kode_arsip = $kode;
        $data->masa_penyimpanan = $masa;
        $data->tanggal_arsip = $tanggal;
        $data->save();

        return response()->json([
            'success'   => true
        ]);
    }

    public function get_arsip_lama(Request $request)
    {
        $nama_surat = $request->nama_surat;
        $ins = $request->ins;
        $data = $this->arsip_lama->get_data($ins, $nama_surat);

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    public function cari_data_umum(Request $request)
    {
        $ins = $request->institusi;
        $name = $request->name;
        $value = $request->input('value');
        $data = Arsip_Umum::where($name, 'LIKE', '%' . $value . '%')->where('institusi', $ins);

        $surat = $data->get();
        return response()->json(['data' => $surat, 'success' => true]);
    }

    public function cari_data_penting(Request $request)
    {
        if($request->nama_surat == ''){
            $this->validate($request, [
                'nama_surat' => 'required'
            ]);
        }else{
            $ins = $request->institusi;
            $nama = $request->input('nama_surat');
            $value = $request->input('value');
            $data = Arsip_Penting::where('nama_surat', 'LIKE', '%' . $nama . '%')
                ->orWhere('tanggal_arsip','LIKE', '%' . $value . '%')
                ->orWhere('masa_penyimpanan','LIKE', '%' . $value . '%')
                ->Where('institusi', $ins);
    
            $surat = $data->get();
        }
        
        return response()->json(['data' => $surat, 'success' => true]);
    }

    public function hapus_data($id, Request $request)
    {
        Arsip_Lama::find($id)->delete();
        return redirect()->back();
    }
}
