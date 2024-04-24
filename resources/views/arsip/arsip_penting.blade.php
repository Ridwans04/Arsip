@extends('layouts/contentLayoutMaster')

@include('arsip.script', ['section' => 'vendor-style'])
@include('arsip.script', ['section' => 'page-style'])

@section('title', 'Data Arsip Surat Penting')

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
                                <select name="nama_surat" id="nama_surat" class="hide-search form-select"
                                    onchange="get_data_arsip('{{ $institusi }}')">
                                    <option value="">Pilih Surat</option>
                                    @foreach ($list_surat as $ls)
                                        <option value="{{ $ls->nama_surat }}">{{ $ls->nama_surat }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="me-1">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text cursor-pointer" style="border: 2px solid #7e7e81;"><i
                                            data-feather="search"></i></span>
                                    <input type="text" id="cari_data_penting" class="form-control"
                                        style="padding-left: 4px;" oninput="cari_data_penting('{{ $institusi }}')"
                                        placeholder="Cari Data....." name="nomor_surat" />
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="card-body mt-2">
                        <div class="card-datatable" style="margin: 7px;">
                            <table id="arsip" class="dt-multilingual table">
                            </table>
                        </div>
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
                                    <form onsubmit="event.preventDefault(),update_data(this)" id="update_arsip"
                                        class="row gy-1 pt-75">
                                        <input type="hidden" name="id_arsip" id="id_arsip">
                                        <div class="col-12 col-md-4">
                                            <label class="form-label">Kode Arsip</label>
                                            <input type="text" id="kode_arsip" name="kode_arsip" class="form-control" />
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <label class="form-label">Tanggal Arsip</label>
                                            <input type="text" id="tgl_arsip" name="tgl_arsip" class="form-control flatpickr-basic" />
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <label class="form-label">Masa Penyimpanan</label>
                                            <input type="text" id="masa_arsip" name="masa_arsip" class="form-control" />
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
