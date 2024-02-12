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

class SuratController extends Controller
{
    public function surat_masuk(Request $request)
    {
        // dump($request->method());
        $surat = Surat::all();
        $key = ['nomor_surat', 'tanggal', 'dari', 'tujuan_surat', 'perihal', 'keterangan'];
        $params = $request->only($key);

        $suratmasuk = Surat::where('jenis_surat', 'Masuk')
                                ->where('klasifikasi', 'UmumMasuk')
                                ->orderBy('created_at', 'desc');

        $suratmasuk->when($request->method() == "POST", function($query) use($key, $suratmasuk, $params, $request){
            $query->where(function($subquery) use($key, $params, $request) {
                collect($key)->map(function($key) use($subquery, $params, $request) {
                    if($request->has($key) && !empty($params[$key])){
                        $condition = $params[$key];
                        $subquery->OrWhere($key, 'like', "%".$condition."%");
                    }
                });
            });
        });

        if(Auth::user()->username == 'Admin' || Auth::user()->username == 'Ketua PI RJ'){
            $suratmasuk = $suratmasuk->get();
           
        }else
        {
            $suratmasuk = $suratmasuk->where('institusi', Auth::user()->institusi)
                                    ->get();
        }
        return view('surat/suratMasuk',compact(['suratmasuk', 'params']));
    }

    public function surat_keluar(Request $request)
    {
        $key = ['nomor_surat', 'tanggal', 'dari', 'tujuan_surat'];
        $params = $request->only($key);

        $suratkeluar = Surat::where('jenis_surat','Keluar')
                                ->where('klasifikasi', 'UmumKeluar')
                                ->orderBy('created_at', 'desc');

        $suratkeluar->when($request->method() == "POST", function($query) use($key, $suratkeluar, $params, $request){
            $query->where(function($subquery) use($key, $params, $request) {
                collect($key)->map(function($key) use($subquery, $params, $request) {
                    if($request->has($key) && !empty($params[$key])){
                        $condition = $params[$key];
                        $subquery->OrWhere($key, 'like', "%".$condition."%");
                    }
                });
            });
            
        });

        if(Auth::user()->username == 'Ketua PI RJ' || Auth::user()->username == 'Admin'){
            $suratkeluar = $suratkeluar->get();
        }else{
            $suratkeluar = $suratkeluar->where('institusi', Auth::user()->institusi)
                                ->get();
        }
        return view('surat.suratKeluar',compact(['suratkeluar', 'params']));
    }

    public function indexPenting(Request $request)
    {
        $surat = Surat::find($request->klasifikasi);
        if(Auth::user()->username == 'Ketua PI RJ' || Auth::user()->username == 'Admin'){
            $suratPenting = Surat::where('klasifikasi', 'Penting')
                              ->orderBy('created_at', 'desc')
                                ->get();
        }else {
            $suratPenting = Surat::where('klasifikasi', 'Penting')
                                    ->where('institusi', Auth::user()->institusi)
                                    ->orderBy('created_at', 'desc')
                                    ->get();
        }
       
        return view('penting.index', compact('surat', 'suratPenting'));
    }

    public function create($jenis_surat, Request $request)
    {
        // return $jenis_surat;
        $dokumen = Dokumen::all();
        $surat = Surat::all();
        $dokumenUmumMasuk = Dokumen::where('klasifikasi', 'UmumMasuk')
                                    ->get();
        $dokumenUmumKeluar = Dokumen::where('klasifikasi', 'UmumKeluar')
                                    ->get();
        $dokumenPenting = Dokumen::where('klasifikasi', 'Penting')
                                    ->get();
        return view('/surat/create', compact(['dokumen', 'surat','dokumenUmumMasuk','dokumenUmumKeluar','dokumenPenting', 'jenis_surat']));
    }

    public function store( Request $request)
    {
        $messages = [
            'nomor_surat.required'    => 'nomor dokumen sudah ada',
            'tanggal_.required'     => 'Mohon Isi Tanggal Surat',
            'dokumen.required'      => 'File dokumen surat belum dipilih',
            'dokumen.mimes'         => 'Upload Dokumen Surat Hanya dengan type PDF'
        ];

        $this->validate($request, [
            'nomor_surat'   => 'required',
            'tanggal'       => 'required',
            'dokumen'       => 'required|file|mimes:pdf'

        ],$messages);

        $dokumen = Dokumen::find($request->dokumen_id);
        $surat = $request->file('dokumen');
        $nama_surat = $surat->getClientOriginalName();
       
        // $disposisi = Disposisi::all();
        $data_surat = Surat::create([
            'institusi'         => Auth::user()->institusi,
            'nama_dokumen'      => $dokumen->nama_dokumen,
            'dokumen_id'        => $dokumen->id,
            'nomor_surat'       => $request->nomor_surat,
            'tanggal'           => $request->tanggal,
            'dari'              => $request->dari,
            'tujuan_surat'      => $request->tujuan_surat,
            'sifat'             => $request->sifat,
            'jenis_surat'       => $request->jenis_surat,
            'klasifikasi'       => $dokumen->klasifikasi,
            'perihal'           => $request->perihal,
            'keterangan'        => $request->keterangan,
            'dokumen'           => $nama_surat
        ]);
        
        $nama = Auth::user()->institusi;
        $tujuan_upload_foto = 'surat/'.$dokumen->klasifikasi.'/'.$nama.'/'.$data_surat->id;
        $surat->move($tujuan_upload_foto,$nama_surat);
        
        if($dokumen->klasifikasi == "Penting")
        {
            return redirect('/penting/index')->with('success', 'Data Berhasil Disimpan');
        }
        elseif($dokumen->klasifikasi == "UmumKeluar")
        {
            return redirect('/surat/suratKeluar')->with('success', 'Data Berhasil Disimpan');
        }
        else
        {
            return redirect('/surat/suratMasuk')->with('success',' Data Berhasil Disimpan');
        }
    }

    public function viewPDF($id)
    {
        $surat = Surat::find($id);
        return view('surat.viewpdf', compact('surat'));
    }

    public function edit($id)
    {
        $surat = Surat::find($id);
        return view('/surat/edit', compact(['surat']));
    }

    public function update($id, Request $request)
        {
            $surat = Surat::find($id);

            if ($request->dokumen=="" && !empty($surat->dokumen)) {
                
                // return $request->tujuan;
                $surat->nama_dokumen        = $request->nama_dokumen;
                $surat->nomor_surat         = $request->nomor_surat;
                $surat->tanggal             = $request->tanggal;
                $surat->dari                = $request->dari;
                $surat->tujuan_surat        = $request->tujuan_surat;
                $surat->sifat               = $request->sifat;
                $surat->perihal             = $request->perihal;
                $surat->keterangan          = $request->keterangan;
            
                $surat->save();
                // File::delete('disposisi/'.$disposisi->nomor_surat.'/'.$disposisi->dokumen);
            } else {
            
                File::delete('surat/'.$surat->klasifikasi.'/'.$surat->institusi.'/'.$surat->id.'/'.$surat->dokumen);
                $data = $request->file('dokumen');
                $nama_surat =$data->getClientOriginalName();
               
                $surat->nama_dokumen        = $request->nama_dokumen;
                $surat->nomor_surat         = $request->nomor_surat;
                $surat->tanggal             = $request->tanggal;
                $surat->dari                = $request->dari;
                $surat->tujuan_surat        = $request->tujuan_surat;
                $surat->sifat               = $request->sifat;
                $surat->perihal             = $request->perihal;
                $surat->keterangan          = $request->keterangan;
                $surat->disposisi_id        = $request->disposisi_id;
                $surat->dokumen             = $nama_surat;
            
                $surat->save();
                $nama = $surat->institusi;
                $tujuan_upload_foto = 'surat/'.$surat->klasifikasi.'/'.$nama.'/'.$surat->id;
                $data->move($tujuan_upload_foto,$nama_surat);
                // return 'data sama';
               
        }
        if($request->klasifikasi == "Penting"){
            return redirect('/penting/index')->with('success', 'Data Berhasil Diupdate');
        }elseif($request->klasifikasi == "UmumMasuk"){
            return redirect('/surat/suratMasuk')->with('success', 'Data Berhasil Diupdate');
        }else{
            return redirect('/surat/suratKeluar')->with('success', 'Data Berhasil Diupdate');
        }
    }

    public function buat()
    {
        return view('surat/buatSurat');
    }

    public function shop(Request $request)
    {
        Dokumen::create([
            'nama_dokumen' => $request->nama_dokumen,
            'klasifikasi' => $request->klasifikasi
        ]);
        return redirect()->back();
        
    }

    public function destroy($id)
    {
        $surat = Surat::where('id',$id)->first();
        if($surat->klasifikasi == 'UmumMasuk')
        {
            if(!empty($surat->disposisi_id)){
            $disposisi = Disposisi::find($surat->disposisi_id);
            File::delete(public_path(implode(DIRECTORY_SEPARATOR, ['disposisi', $disposisi->institusi, $disposisi->nomor_surat, $disposisi->dokumen ])));
            File::deleteDirectory(public_path(implode(DIRECTORY_SEPARATOR, ['disposisi', $disposisi->institusi, $disposisi->nomor_surat])));
            $disposisi->delete();
            }
        }elseif($surat->klasifikasi == 'UmumKeluar'){
            if(!empty($surat->ekspedisi_id)){
            $ekspedisi = Ekspedisi::find($surat->ekspedisi_id);
            $ekspedisi->delete();
            }
        }
	   
        File::delete(public_path(implode(DIRECTORY_SEPARATOR, ['surat', $surat->klasifikasi, $surat->institusi, $surat->id, $surat->dokumen ])));
        File::deleteDirectory(public_path(implode(DIRECTORY_SEPARATOR, ['surat', $surat->klasifikasi, $surat->institusi, $surat->id ])));
	    Surat::where('id',$id)->delete();
        // Storage::delete('surat/'.$surat->klasifikasi.'/'.$surat->institusi.'/'.$surat->nomor_surat);

        return redirect()->back();
    }
}
