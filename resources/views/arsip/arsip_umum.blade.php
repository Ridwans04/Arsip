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
                        <div class="row">
                            {{-- <div class="col-md-4 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="search">Pencarian Nomor Surat</label>
                                    <input type="text" id="search" class="form-control"
                                        placeholder="Masukkan Nomor dokumen" name="nomor_surat" />
                                </div>
                            </div> --}}
                            <div class="col-md-4 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="search">Tanggal</label>
                                    <input type="text" name="tanggal" id="search"
                                        class="form-control" placeholder="Tahun-Bulan-Hari" />
                                </div>
                            </div>
                            <div class=" col-12">
                                <button type="button" onclick="cari_data('{{ $institusi }}')" class="btn btn-icon btn-danger me-1">
                                    <i data-feather="search"></i>
                                </button>
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
