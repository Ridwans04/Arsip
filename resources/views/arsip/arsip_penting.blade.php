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
                                <button class="btn btn-outline-success"
                                    onclick="get_arsip_penting('{{ $institusi }}')">Refresh tabel</button>
                            </div>
                            <div class="mb-1">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text cursor-pointer" style="border: 2px solid #7e7e81;"><i data-feather="search"></i></span>
                                    <input type="text" id="nomor_surat" class="form-control"
                                        oninput="cari_data('nomor_surat','{{ $institusi }}')" placeholder="    Cari Data"
                                        name="nomor_surat" />
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="card-body mt-2">
                        <div class="card-datatable" style="margin: 7px;">
                            <table id="arsip_penting" class="dt-multilingual table">
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@include('arsip.script', ['section' => 'vendor-script'])
@include('arsip.script', ['section' => 'page-script'])
