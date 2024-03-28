<?php

namespace App\Http\Controllers;

use App\Models\Data\Arsip;
use App\Models\Data\Disposisi;
use App\Models\Data\Ekspedisi;
use App\Models\Data\Surat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use File;

class ArsipController extends Controller
{
    public function index(Request $request)
    {
        $key = ['nomor_dokumen', 'tanggal_arsip', 'nama_dokumen', 'kode_arsip'];
        $params = $request->only($key);
        if(Auth::user()->username == 'Admin' || Auth::user()->username == 'Ketua PI RJ'){
            $arsip = Arsip::orderBy('created_at', 'desc');
        }else{
            $arsip = Arsip::where('institusi', Auth::user()->institusi)
                            ->orderBy('created_at', 'desc');
        }
        $arsip->when($request->method() == "POST", function($query) use($key, $arsip, $params, $request){
            $query->where(function($subquery) use($key, $params, $request) {
                collect($key)->map(function($key) use($subquery, $params, $request) {
                    if($request->has($key) && !empty($params[$key])){
                        $condition = $params[$key];
                        $subquery->OrWhere($key, 'like', "%".$condition."%");
                    }
                });
            });
            
        });
        $arsip = $arsip->get();
        return view('temp.index', compact(['arsip', 'params']));
    }

    public function cari_arsip(Request $request)
    {
        $result = $request->search;
        $arsip = Arsip::where('nomor_dokumen', 'like', "%{$result}%")
                ->orWhere('tanggal_arsip', 'like', "%{$result}%")
                ->orWhere('nama_dokumen', 'like', "%{$result}%")
                ->orWhere('kode_arsip', 'like', "%{$result}%")
                ->orderBy('created_at', 'desc')->get();
        return view('arsip.index',compact(['arsip']));
    }

    public function create(Request $request)
    {
        $surat = Surat::all();
        $suratMasuk = Surat::where('klasifikasi', 'UmumMasuk')
                                ->where('institusi', Auth::user()->institusi)
                                ->orderBy('created_at', 'desc')
                                ->get();
        $suratKeluar = Surat::where('klasifikasi', 'UmumKeluar')
                                ->where('institusi', Auth::user()->institusi)
                                ->orderBy('created_at', 'desc')
                                ->get();
        $suratPenting = Surat::where('klasifikasi', 'Penting')
                                ->where('institusi', Auth::user()->institusi)
                                ->orderBy('created_at', 'desc')
                                ->get();
        return view('/arsip/create', compact('surat', 'suratMasuk', 'suratKeluar', 'suratPenting'));
    }

    public function store(Request $request)
    {
        $messages = [
            'surat_id.unique'      => 'Nomor dokumen sudah tersedia',
            'tanggal.required'          => 'Mohon Isi Tanggal Surat'
        ];

        $this->validate($request, [
            'surat_id'          => 'required|unique:arsip,nomor_dokumen',
            'tanggal_arsip'     => 'required'

        ],$messages);

        $surat = Surat::find($request->surat_id);
        $data = Arsip::create([
            'institusi'         => Auth::user()->institusi,
            'surat_id'          => $surat->id,
            'nomor_dokumen'     => $surat->nomor_surat,
            'nama_dokumen'      => $surat->nama_dokumen,
            'kode_arsip'        => $request->kode_arsip,
            'tanggal_arsip'     => $request->tanggal_arsip,
            'masa'              => $request->masa,
            'disposisi_id'      => $surat->disposisi_id
        ]);
        $data_surat = Surat::find($surat->id);
        $data_surat->arsip_id = $data->id;
        $data_surat->save();
        return redirect('/arsip/index')->with('success', 'Data Berhasil Disimpan');
    }

    public function buat($id)
    {
        $surat = Surat::find($id);
        return view('/arsip/suratArsip', compact(['surat']));
    }

    public function shop(Request $request)
    {
        $messages = [
            'tanggal.required'         => 'Mohon Isi Tanggal Surat'
        ];

        $this->validate($request, [
            'tanggal_arsip' => 'required'

        ],$messages);
       
        $surat = Surat::find($request->surat_id);
        $data=Arsip::create([
            'institusi'         => Auth::user()->institusi,
            'surat_id'          => $request->surat_id,
            'nomor_dokumen'     => $request->nomor_dokumen,
            'nama_dokumen'      => $request->nama_dokumen,
            'kode_arsip'        => $request->kode_arsip,
            'tanggal_arsip'     => $request->tanggal_arsip,
            'masa'              => $request->masa,
            'disposisi_id'      => $request->disposisi_id
        ]);
        $surat->arsip_id = $data->id;
        $surat->save();
        return redirect('/arsip/index')->with('success', 'Data Berhasil Disimpan');
    }

    public function edit($id, Request $request)
    {
        $read_only = $request->read_only??false;
        $arsip = Arsip::find($id);
        return view('/temp/edit', compact('arsip', 'read_only'));
    }

    public function update($id, Request $request)
    {
        // $surat = Surat::find($request->id);
        $arsip = Arsip::find($id);
        $arsip->nomor_dokumen       = $request->nomor_dokumen;
        $arsip->nama_dokumen        = $request->nama_dokumen;
        $arsip->kode_arsip          = $request->kode_arsip;
        $arsip->tanggal_arsip       = $request->tanggal_arsip;
        $arsip->masa                = $request->masa;
        $arsip->disposisi_id        = $request->disposisi_id;
        $arsip->save();
        
        return redirect('/arsip/index');
    }

    public function destroy($id)
    {
        $arsip = Arsip::find($id);
        $surat = Surat::find($arsip->surat_id);
        // return $arsip->surat_id;
        if(!empty($surat->disposisi_id))
        {
            $disposisi = Disposisi::find($surat->disposisi_id);
            File::delete(public_path(implode(DIRECTORY_SEPARATOR, ['disposisi', $disposisi->institusi, $disposisi->nomor_surat, $disposisi->dokumen ])));
            File::deleteDirectory(public_path(implode(DIRECTORY_SEPARATOR, ['disposisi', $disposisi->institusi, $disposisi->nomor_surat])));
            $disposisi->delete();
        }elseif(!empty($surat->ekspedisi_id)){
            $ekspedisi = Ekspedisi::find($surat->ekspedisi_id);
            $ekspedisi->delete();
        }
        if(!empty($surat->dokumen))
        { 
            File::delete(public_path(implode(DIRECTORY_SEPARATOR, ['surat', $surat->klasifikasi, $surat->institusi, $surat->nomor_surat, $surat->dokumen ])));
            File::deleteDirectory(public_path(implode(DIRECTORY_SEPARATOR, ['surat', $surat->klasifikasi, $surat->institusi, $surat->nomor_surat ])));
            $surat->delete();
        }
        
        $arsip->delete();
       
        return redirect()->back();
    }
}
