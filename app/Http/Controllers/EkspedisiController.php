<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ekspedisi;
use App\Models\Surat;
use Illuminate\Support\Facades\Auth;

class EkspedisiController extends Controller
{
    public function index(Request $request)
    {
       
        $key = ['nomor_surat', 'tanggal_surat', 'tanggal_kirim', 'nama_penerima'];
        $params = $request->only($key);
        if(Auth::user()->username == 'Admin' || Auth::user()->username == 'Ketua PI RJ'){
            $ekspedisi = Ekspedisi::orderby('id');
        }else{
            $ekspedisi = Ekspedisi::where('institusi', Auth::user()->institusi);                             
        }
        $ekspedisi->when($request->method() == "POST", function($query) use($key, $ekspedisi, $params, $request){
            $query->where(function($subquery) use($key, $params, $request) {
                collect($key)->map(function($key) use($subquery, $params, $request) {
                    if($request->has($key) && !empty($params[$key])){
                        $condition = $params[$key];
                        $subquery->OrWhere($key, 'like', "%".$condition."%");
                    }
                });
            });
            
        });
        $ekspedisi = $ekspedisi->get();
        return view('ekspedisi.index', compact(['ekspedisi', 'params']));
    }

    public function create()
    {
        $suratKeluar = Surat::where('klasifikasi', 'UmumKeluar')
                                ->get();
        return view('ekspedisi/create', compact(['suratKeluar']));
    }

    public function store(Request $request)
    {
        $messages = [
            'surat_id.unique'        => 'Nomor surat sudah ada',
            'tanggal_kirim.required' => 'Mohon Isi Tanggal Kirim',
            'tanggal_surat.required' => 'Mohon Isi Tanggal Surat'
        ];

        $this->validate($request, [
            'surat_id'      => 'required|unique:ekspedisi,surat_id',
            'tanggal_kirim' => 'required',
            'tanggal_surat' => 'required'

        ],$messages);

        $surat=Surat::find($request->surat_id);
        $data=Ekspedisi::create([
            'institusi'         => Auth::user()->institusi,
            'surat_id'          => $surat->id,
            'tanggal_kirim'     => $request->tanggal_kirim,
            'nomor_surat'       => $surat->nomor_surat,
            'tanggal_surat'     => $request->tanggal_surat,
            'perihal'           => $request->perihal,
            'jenis'             => $request->jenis,
            'nama_penerima'     => $request->nama_penerima
        ]);
        $data_surat = Surat::find($surat->id);
        $data_surat->ekspedisi_id = $data->id;
        $data_surat->save();
        return redirect('/ekspedisi/index')->with('success', 'Data berhasil disimpan');
    }

    public function buat($id)
    {
        $surat = Surat::find($id);
        return view('ekspedisi/suratEkspedisi', compact(['surat']));
    }

    public function shop(Request $request)
    {
        $messages = [
           
            'tanggal_kirim.required' => 'Mohon Isi Tanggal Kirim',
            'tanggal_surat.required' => 'Mohon Isi Tanggal Surat'
        ];

        $this->validate($request, [
            'tanggal_kirim' => 'required',
            'tanggal_surat' => 'required'

        ],$messages);

        $surat=Surat::find($request->surat_id);
        $data=Ekspedisi::create([
            'institusi'         => Auth::user()->institusi,
            'tanggal_kirim'     => $request->tanggal_kirim,
            'nomor_surat'       => $request->nomor_surat,
            'tanggal_surat'     => $request->tanggal_surat,
            'perihal'           => $request->perihal,
            'jenis'             => $request->jenis,
            'nama_penerima'     => $request->nama_penerima
        ]);
        $surat->ekspedisi_id = $data->id;
        $surat->save();
        return redirect('/surat/suratKeluar')->with('success', 'Ekspedisi berhasil disimpan');
    }

    public function edit($id, Request $request)
    {
        $read_only = $request->read_only ?? false;
        $ekspedisi = Ekspedisi::find($id);
        return view('ekspedisi.edit',compact(['ekspedisi', 'read_only']));
    }

    public function update($id, Request $request)
    {
        $ekspedisi = Ekspedisi::find($id);
        $ekspedisi->update([
            'tanggal_kirim'     => $request->tanggal_kirim,
            'nomor_surat'       => $request->nomor_surat,
            'tanggal_surat'     => $request->tanggal_surat,
            'perihal'           => $request->perihal,
            'jenis'             => $request->jenis,
            'nama_penerima'     => $request->nama_penerima
        ]);
        return redirect('/ekspedisi/index');
    }

    public function destroy($id)
    {
        $ekspedisi = Ekspedisi::find($id);
        $data_surat = Surat::find($ekspedisi->surat_id);
        $data_surat->ekspedisi_id = null;
        $data_surat->save();
        $ekspedisi->delete();
        return redirect()->back();
    }
}
