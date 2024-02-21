@extends('layouts/contentLayoutMaster')

@include('arsip.script', ['section' => 'vendor-style'])
@include('arsip.script', ['section' => 'page-style'])

@section('title', 'Tabel Arsip Surat')

@section('content')
    <section id="complex-header-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    @if (Auth::user()->level == 'Admin')
                        <div class="card-header border-bottom p-1">
                            @php
                                $institusi = Auth::user()->institusi;
                            @endphp

                            <div class="col-md-3" style="margin-left: 7px">
                                <select name="jenis" id="jenis_surat" class="hide-search form-select"
                                    onchange="get_data_arsip('{{ $institusi }}')">
                                    <option>Pilih Jenis Surat</option>
                                    <option value="UmumKeluar">Surat Umum Eksternal</option>
                                    <option value="UmumMasuk">Surat Umum Internal</option>
                                </select>
                            </div>
                        </div>
                    @endif
                    <div class="card-body mt-2">
                        <button class="btn btn-outline-secondary" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                            Form Pencarian
                        </button>
                        <div class="collapse" id="collapseExample">
                            <div class="d-flex p-1 border">
                                <form action="{{ route('cari_data') }}" method="POST" class="form" id="jquery-val-form">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-4 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="nomor">Nomor Dokumen</label>
                                                <input type="text" id="nomor" class="form-control"
                                                    placeholder="Masukkan Nomor dokumen" name="nomor_surat" />
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="fp">Tanggal</label>
                                                <input type="text" name="tanggal" id="fp"
                                                    class="form-control flatpickr-basic" placeholder="Tahun-Bulan-Hari" />
                                            </div>
                                        </div>
                                        <div id="dari" class="col-md-4 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="dari">Dari</label>
                                                <input type="text" id="dri" class="form-control" name="dari"
                                                    placeholder="Tulis Disini" />
                                            </div>
                                        </div>
                                        <div id="tujuan" class="col-md-4 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="tujuan">Tujuan Surat</label>
                                                <input type="text" id="tjn" class="form-control"
                                                    name="tujuan_surat" placeholder="Tulis Disini" />
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="prhl">Perihal</label>
                                                <input type="text" id="prhl" class="form-control" name="perihal"
                                                    placeholder="Tulis Disini" />
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="ket">Keterangan</label>
                                                <input type="text" id="ket" class="form-control" name="keterangan"
                                                    placeholder="Tulis Disini" />
                                            </div>
                                        </div>
                                        <div class=" col-12">
                                            <button type="submit" class="btn btn-icon btn-danger me-1">
                                                <i data-feather="search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-datatable" style="margin: -10px 5px 10px 25px;">
                        <table id="arsip" class="dt-multilingual table">
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@include('arsip.script', ['section' => 'vendor-script'])
@include('arsip.script', ['section' => 'page-script'])
