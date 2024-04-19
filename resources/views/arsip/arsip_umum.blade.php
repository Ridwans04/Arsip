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

                            <div class="btn-group">
                                <div class="col-md-8" style="margin-left: 7px">
                                    <select name="klasifikasi" id="klasifikasi" class="hide-search form-select"
                                        onchange="klasifikasi_surat()">
                                        <option>Pilih Klasifikasi Surat</option>
                                        <option value="Keluar">Surat Keluar</option>
                                        <option value="Masuk">Surat Masuk</option>
                                    </select>
                                </div>
                                <div class="col-md-10" style="margin-left: 7px">
                                    <select name="nama_surat" id="nama_surat" class="hide-search form-select"
                                        onchange="get_data_arsip('{{ $institusi }}')">
                                        <option value="">Pilih Nama Surat</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    @endif
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
                                            <input type="text" name="tanggal" id="tanggal" class="form-control"
                                                oninput="cari_data('tanggal','{{ $institusi }}')"
                                                placeholder="Tahun-Bulan-Hari" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="mb-1">
                                            <label class="form-label" for="tujuan_surat">Tujuan Surat</label>
                                            <input type="text" id="tujuan_surat" class="form-control" name="tujuan_surat"
                                                oninput="cari_data('tujuan_surat','{{ $institusi }}')"
                                                placeholder="Tulis Disini" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="mb-1">
                                            <label class="form-label" for="perihal">Perihal</label>
                                            <input type="text" id="perihal" class="form-control" name="perihal"
                                                placeholder="Tulis Disini"
                                                oninput="cari_data('perihal','{{ $institusi }}')" />
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
                    <div class="modal fade" id="modal_detail" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body pb-5 px-sm-5 pt-50">
                                    <div class="text-center mb-2">
                                        <h1 class="mb-1">Detail dan Edit Data Arsip</h1>
                                        <p>Update data arsip jika diperlukan</p>
                                    </div>
                                    <form onsubmit="event.preventDefault(),update_data(this)" id="update_arsip" class="row gy-1 pt-75" onsubmit="">
                                        <input type="hidden" name="id_arsip" id="id_arsip">
                                        <div class="col-12 col-md-4">
                                            <label class="form-label">Kode Arsip</label>
                                            <input type="text" id="kode_arsip" class="form-control"  />
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <label class="form-label">Tanggal Arsip</label>
                                            <input type="text" id="tgl_arsip" class="form-control"  />
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <label class="form-label">Masa Penyimpanan</label>
                                            <input type="text" id="masa_arsip" class="form-control"  />
                                        </div>
                                        <div class="col-12 text-center mt-2 pt-50">
                                            <button type="submit" class="btn btn-primary me-1">Perbarui</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@include('arsip.script', ['section' => 'vendor-script'])
@include('arsip.script', ['section' => 'page-script'])
