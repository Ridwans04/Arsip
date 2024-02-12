<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Disposisi;
use App\Models\Surat;
use App\Models\Tujuan;
use Illuminate\Http\Request;
use File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class DisposisiController extends Controller
{
    public function index(Request $request)
    {
        if(Auth::user()->username == 'Admin' || Auth::user()->username == 'Ketua PI RJ'){
            $disposisi = Disposisi::all();
        }else{
            $disposisi = Disposisi::where('institusi', Auth::user()->institusi)
                            ->orderBy('created_at', 'desc')
                            ->get();                          
        }
        return view('disposisi.index',compact(['disposisi']));
    }

    public function create()
    {
        $surat = Surat::all();
        $suratmasuk = Surat::where('jenis_surat', 'Masuk')
                            ->where('institusi', Auth::user()->institusi)
                            ->orderBy('created_at', 'desc')
                            ->get();
        $tujuan = Tujuan::all();
        return view('/disposisi/create', compact(['surat','tujuan','suratmasuk']));
    }

    public function store(Request $request)
    {
        $messages = [
            'surat_id.unique'           => 'Nomor dokumen sudah ada',
            'tanggal_terima.required'   => 'Mohon Isi Tanggal Terima Surat',
            'dokumen.required'          => 'File dokumen surat belum dipilih',
            'dokumen.mimes'             => 'Upload Dokumen Surat Hanya dengan type PDF'
        ];

        $this->validate($request, [
            'surat_id'       => 'required|unique:disposisi,surat_id',
            'tanggal_terima' => 'required',
            'dokumen'        => 'required|file|mimes:jpeg,png,jpg'

        ],$messages);
        
        $surat = Surat::find($request->surat_id);
        $disposisi = $request->file('dokumen');
        $nama_disposisi =$request->nama_surat."_".$disposisi->getClientOriginalName();

        $nama = Auth::user()->institusi;
        $tujuan_upload_foto = 'disposisi/'.$nama.'/'.$surat->id;
        $disposisi->move($tujuan_upload_foto,$nama_disposisi);
      
        $tujuan = Tujuan::whereIn('id', $request->tujuan_id)->get();
        // dump($tujuan);
        $tujuan_id = $tujuan->pluck('id')->join(',');
        $tujuan_nama = $tujuan->pluck('tujuan')->join(',');
        

        $data=Disposisi::create([
              'institusi'           => Auth::user()->institusi,
              'nomor_surat'         => $surat->nomor_surat,
              'surat_id'            => $surat->id,
              'tujuan_id'           => $tujuan_id,
              'tanggal_terima'      => $request->tanggal_terima,
              'tujuan'              => $tujuan_nama,
              'catatan'             => $request->catatan,
              'tindak_lanjut'       => $request->tindak_lanjut,
              'keterangan'          => $request->keterangan,
              'dokumen'             => $nama_disposisi
        ]);
        $data_surat = Surat::find($surat->id);
        $data_surat->disposisi_id = $data->id;
        $data_surat->save();
        return redirect('/disposisi/index')->with('success', 'Data berhasil disimpan');
    }

    public function buat($id)
    {
        $surat = Surat::find($id);
        $tujuan = Tujuan::all();
        return view('/disposisi/suratDisposisi', compact(['surat','tujuan']));
    }

    public function shop(Request $request)
    {
        $messages = [
            'tanggal_terima.required'   => 'Mohon Isi Tanggal Terima Surat',
            'dokumen.required'          => 'File dokumen surat belum dipilih',
            'dokumen.mimes'             => 'Upload Dokumen Surat Hanya dengan type jpg, jpeg, atau png'
        ];
        

        $this->validate($request, [
            'tanggal_terima' => 'required',
            'dokumen'        => 'required|file|mimes:jpeg,png,jpg'

        ],$messages);
        
        
        $surat = Surat::find($request->surat_id);
        $disposisi = $request->file('dokumen');
        $nama_disposisi =$request->nama_surat."_".$disposisi->getClientOriginalName();

        $nama = Auth::user()->institusi;
        $tujuan_upload_foto = 'disposisi/'.$nama.'/'.$surat->id;
        $disposisi->move($tujuan_upload_foto,$nama_disposisi);
      
        $tujuan = Tujuan::whereIn('id', $request->tujuan_id)->get();
        // dump($tujuan);
        $tujuan_id = $tujuan->pluck('id')->join(',');
        $tujuan_nama = $tujuan->pluck('tujuan')->join(',');
        
        $data=Disposisi::create([
              'institusi'           => Auth::user()->institusi,
              'nomor_surat'         => $request->nomor_surat,
              'surat_id'            => $request->surat_id,
              'tujuan_id'           => $tujuan_id,
              'tanggal_terima'      => $request->tanggal_terima,
              'tujuan'              => $tujuan_nama,
              'catatan'             => $request->catatan,
              'tindak_lanjut'       => $request->tindak_lanjut,
              'keterangan'          => $request->keterangan,
              'dokumen'             => $nama_disposisi
        ]);
        $surat->disposisi_id = $data->id;
        $surat->save();
        return redirect('/surat/suratMasuk')->with('success', 'Disposisi berhasil disimpan');
    }

    public function edit(Request $request, $id)
    {
        $read_only = $request->read_only??false;
        $disposisi = Disposisi::find($id);

        $tujuan = Tujuan::all();
        $tujuan_id = $disposisi->tujuan_id ? explode(',', $disposisi->tujuan_id) : '';
        // $tujuan_nama = $tujuan->pluck('tujuan')->split(',');
        return view('disposisi.edit', compact(['disposisi','tujuan', 'tujuan_id', 'read_only' ]));
    }

    public function update($id, Request $request)
    {
        $disposisi = Disposisi::find($id);
        $tujuan = Tujuan::all();

        if ($request->dokumen=="" && !empty($disposisi->dokumen)) {
            $tujuan = Tujuan::whereIn('id', $request->tujuan_id)->get();
            // dump($tujuan);
            $tujuan_id = $tujuan->pluck('id')->join(',');
            $tujuan_nama = $tujuan->pluck('tujuan')->join(',');

            $disposisi->tanggal_terima  = $request->tanggal_terima;
            $disposisi->tujuan          = $tujuan_nama;
            $disposisi->catatan         = $request->catatan;
            $disposisi->tindak_lanjut   = $request->tindak_lanjut;
            $disposisi->keterangan      = $request->keterangan;
            $disposisi->tujuan_id       = $tujuan_id;
            $disposisi->save();
        } else {

            File::delete('disposisi/'.$disposisi->institusi.'/'.$disposisi->surat_id.'/'.$disposisi->dokumen);
            $data = $request->file('dokumen');
            $nama_disposisi =$disposisi->nama_surat."_".$data->getClientOriginalName();

            $nama = Auth::user()->institusi;
            $tujuan_upload_foto = 'disposisi/'.$nama.'/'.$disposisi->surat_id;
            $data->move($tujuan_upload_foto,$nama_disposisi);
            $tujuan = Tujuan::whereIn('id', $request->tujuan_id)->get();
            // dump($tujuan);
            $tujuan_id = $tujuan->pluck('id')->join(',');
            $tujuan_nama = $tujuan->pluck('tujuan')->join(',');

           
            $disposisi->tanggal_terima  = $request->tanggal_terima;
            $disposisi->tujuan          = $tujuan_nama;
            $disposisi->catatan         = $request->catatan;
            $disposisi->tindak_lanjut   = $request->tindak_lanjut;
            $disposisi->keterangan      = $request->keterangan;
            $disposisi->dokumen         = $nama_disposisi;
            $disposisi->tujuan_id       = $tujuan_id;
            $disposisi->save();
            // return 'data sama';
        }
        return redirect('/disposisi/index');
    }

    public function lihatFoto($id)
    {
        $disposisi = Disposisi::find($id);
        return view('disposisi.index', compact('disposisi'));
    }

    public function destroy($id)
    {
        $disposisi = Disposisi::find($id);
        $data_surat = Surat::find($disposisi->surat_id);
        $data_surat->disposisi_id = null;
        $data_surat->save();
       
	// hapus data
        // File::delete('disposisi/'.$disposisi->institusi.'/'.$disposisi->nomor_surat.'/'.$disposisi->dokumen);
        File::delete(public_path(implode(DIRECTORY_SEPARATOR, ['disposisi', $disposisi->institusi, $disposisi->surat_id, $disposisi->dokumen ])));
        File::deleteDirectory(public_path(implode(DIRECTORY_SEPARATOR, ['disposisi', $disposisi->institusi, $disposisi->surat_id])));
	    $disposisi->delete();
       
      
 
	return redirect()->back();
    }
}
