@extends('layouts/contentLayoutMaster')

@include('arsip_lama.script', ['section' => 'vendor-style'])
@include('arsip_lama.script', ['section' => 'page-style'])

@section('title', 'Tabel Arsip Surat')

@section('content')
    <section id="complex-header-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom p-1">
                        @php
                            $institusi = Auth::user()->institusi;
                        @endphp
                        <div class="btn-group">
                            <div class="col-md-8" style="margin-left: 7px">
                                <select name="klasifikasi" id="klasifikasi" class="hide-search form-select"
                                    onchange="klasifikasi_surat()">
                                    <option>Pilih Klasifikasi Surat</option>
                                    <option value="Keluar">Surat Keluar</option>
                                    <option value="Masuk">Surat Masuk</option>
                                    <option value="Penting">Surat Penting</option>
                                </select>
                            </div>
                            <div class="col-md-10" style="margin-left: 7px">
                                <select name="nama_surat" id="nama_surat" class="hide-search form-select"
                                    onchange="get_arsip_lama('{{ $institusi }}')">             
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-body mt-2">
                        <button class="btn btn-secondary" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                            Form Pencarian
                        </button>
                        <div class="collapse" id="collapseExample">
                            <div class="d-flex p-1">
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="mb-1">
                                            <label class="form-label" for="nomor_surat">Nomor Surat</label>
                                            <input type="text" id="nomor_surat" class="form-control"
                                                oninput="cari_data('nomor_surat','{{ $institusi }}')"
                                                placeholder="Masukkan Nomor dokumen" name="nomor_surat" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="mb-1">
                                            <label class="form-label" for="tanggal">Tanggal</label>
                                            <input type="text" name="tanggal" id="tanggal" class="form-control flatpickr-basic"
                                                oninput="cari_data('tanggal_arsip','{{ $institusi }}')"
                                                placeholder="Tahun-Bulan-Hari" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="mb-1">
                                            <label class="form-label" for="tujuan_surat">Kode Arsip</label>
                                            <input type="text" id="tujuan_surat" class="form-control" name="tujuan_surat"
                                                oninput="cari_data('kode_arsip','{{ $institusi }}')"
                                                placeholder="Tulis Disini" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="mb-1">
                                            <label class="form-label" for="perihal">Masa</label>
                                            <input type="text" id="masa" class="form-control" name="perihal"
                                                placeholder="Tulis Disini"
                                                oninput="cari_data('masa_penyimpanan','{{ $institusi }}')" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-datatable" style="margin: -10px 5px 10px 25px;">
                        <table id="arsip" class="dt-multilingual table">
                        </table>
                    </div>
                    @include('arsip_lama.catatan_arsip')
                    @include('arsip_lama.catatan_ekspedisi')
                </div>
            </div>
        </div>
    </section>
@endsection

@include('arsip_lama.script', ['section' => 'vendor-script'])
@include('arsip_lama.script', ['section' => 'page-script'])
