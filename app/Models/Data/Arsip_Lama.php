<?php

namespace App\Models\Data;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Arsip_Lama extends Model
{
    use HasFactory;
    protected $table = 'surat_lama';
    protected $guarded = [];

    public function get_data($ins, $nama_surat)
    {
        return DB::table('surat_lama')
            ->select(['surat_lama.*', 'catatan_arsip_lama.kode_arsip', 'catatan_arsip_lama.tanggal_arsip', 'catatan_arsip_lama.masa', 'ekspedisi.tanggal_kirim', 'ekspedisi.nama_penerima'])
            ->leftJoin('catatan_arsip_lama', 'surat_lama.arsip_id', '=', 'catatan_arsip_lama.id')
            ->leftJoin('ekspedisi', 'surat_lama.ekspedisi_id', '=', 'ekspedisi.id')
            ->where('surat_lama.nama_surat', $nama_surat)
            ->where('surat_lama.institusi', $ins)
            ->orderBy('surat_lama.id', 'desc')
            ->get()
            ->toArray();
    }
}
