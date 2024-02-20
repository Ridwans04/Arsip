@extends('layouts/contentLayoutMaster')

@section('vendor-style')
    {{-- vendor css files TABLE --}}
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
    {{-- Vendor Css Extension --}}
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
@endsection

@section('page-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
@endsection

@section('title', 'Tabel Surat Keluar')

@section('content')
    <!-- Complex Headers -->

    <section id="complex-header-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    @if (Auth::user()->level == 'Admin')
                        <div class="card-header border-bottom p-1">
                            <div class="head-label">
                                @php
                                    $jenis_surat = 'Surat Keluar';
                                @endphp
                                <button class="btn btn-relief-success round waves-effect" type="button"
                                    onclick="window.location.href='/surat/create/{{ $jenis_surat }}'">
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-plus me-50 font-small-4">
                                            <line x1="12" y1="5" x2="12" y2="19"></line>
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                        </svg>
                                        Surat Keluar
                                    </span>
                                </button>
                            </div>
                        </div>
                    @else
                    @endif

                    <div class="card-datatable" style="margin:5px;">
                        <div class="card-body">
                            <form action="#" method="POST" class="form" id="jquery-val-form"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <label class="form-label" for="nomor">Nomor Dokumen</label>
                                            <input type="text" id="nomor" class="form-control"
                                                placeholder="Masukkan Nomor dokumen"
                                                value="{{ $params['nomor_surat'] ?? '' }}" name="nomor_surat" />
                                        </div>
                                    </div>
                                    <!-- JENIS SURAT -->

                                    <div class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <label class="form-label" for="fp">Tanggal</label>
                                            <input type="text" name="tanggal" id="fp"
                                                value="{{ $params['tanggal'] ?? '' }}" class="form-control flatpickr-basic"
                                                placeholder="Tahun-Bulan-Hari" />
                                        </div>
                                    </div>
                                    <div id="dari" class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <label class="form-label" for="dari">Dari</label>
                                            <input type="text" id="dri" class="form-control" name="dari"
                                                value="{{ $params['dari'] ?? '' }}" placeholder="Tulis Disini" />
                                        </div>
                                    </div>
                                    <div id="tujuan" class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <label class="form-label" for="tujuan">Tujuan Surat</label>
                                            <input type="text" id="tjn" class="form-control" name="tujuan_surat"
                                                value="{{ $params['tujuan_surat'] ?? '' }}" placeholder="Tulis Disini" />
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <label class="form-label" for="prhl">Perihal</label>
                                            <input type="text" id="prhl" class="form-control" name="perihal"
                                                value="{{ $params['perihal'] ?? '' }}" placeholder="Tulis Disini" />
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <label class="form-label" for="ket">Keterangan</label>
                                            <input type="text" id="ket" class="form-control"
                                                name="tujuan_surat" value="{{ $params['keterangan'] ?? '' }}"
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

                        <div class="card-datatable" style="margin:5px;">
                            <table id="suratKeluar" class="dt-multilingual table">
                                <thead>
                                    <tr>
                                        @if (Auth::user()->username == 'Admin' || Auth::user()->username == 'Ketua PI RJ')
                                            <th>Institusi</th>
                                            <th>Nomor Surat</th>
                                            <th>Nama Surat</th>
                                            <th>Tanggal</th>
                                            <th>Dari</th>
                                            <th>Tujuan Surat</th>
                                            <th>Aksi</th>
                                        @else
                                            <th>Nomor Surat</th>
                                            <th>Nama Surat</th>
                                            <th>Tanggal</th>
                                            <th>Dari</th>
                                            <th>Tujuan Surat</th>
                                            <th>Aksi</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($suratkeluar as $sk)
                                        <tr>
                                            @if (Auth::user()->username == 'Admin' || Auth::user()->username == 'Ketua PI RJ')
                                                <td>{{ $sk->institusi }}</td>
                                                <td>{{ $sk->nomor_surat }}</td>
                                                <td>{{ $sk->nama_dokumen }}</td>
                                                <td>{{ $sk->tanggal }}</td>
                                                <td>{{ $sk->dari }}</td>
                                                <td>{{ $sk->tujuan_surat }}</td>
                                                @if (Auth::user()->level == 'Admin')
                                                    <td>
                                                        <!-- <div class="btn-group" role="group" aria-label="Basic example"> -->
                                                        <div class="demo-inline-spacing mb-2">
                                                            <button
                                                                onclick="window.location.href='/surat/{{ $sk->id }}/edit'"
                                                                data-bs-toggle="tooltip" data-bs-placement="right"
                                                                title="Edit Surat" type="button"
                                                                class="btn btn-icon btn-success ">
                                                                <i data-feather="edit"></i></button>
                                                            <a href="{{ url('surat/viewpdf', $sk->id) }}"
                                                                data-bs-toggle="tooltip" data-bs-placement="right"
                                                                title="Lihat Surat" target="_blank"
                                                                class="btn btn-icon btn-success"><i
                                                                    data-feather="file-plus"></i></a>
                                                            <form id="hapus_{{ $sk->id }}"
                                                                action="/surat/{{ $sk->id }}" method="POST">
                                                                @csrf
                                                                @method('delete')
                                                                <button type="button" class="btn btn-icon btn-danger"
                                                                    data-bs-toggle="tooltip" data-bs-placement="right"
                                                                    title="Hapus Surat"
                                                                    onclick="notif_delete({{ $sk->id }})"
                                                                    value="delete">
                                                                    <i data-feather="trash"></i>
                                                                </button>
                                                            </form>
                                                            @if (empty($sk->ekspedisi_id))
                                                                <a href="../ekspedisi/{{ $sk->id }}/suratEkspedisi"
                                                                    data-bs-toggle="tooltip" data-bs-placement="right"
                                                                    title="Buat Ekspedisi" target="_blank"
                                                                    class="btn btn-icon btn-info"><i
                                                                        data-feather="book-open"></i></a>
                                                            @else
                                                                <a href="../ekspedisi/{{ $sk->ekspedisi_id }}/edit?read_only=1"
                                                                    data-bs-toggle="tooltip" data-bs-placement="right"
                                                                    title="Lihat Ekspedisi" target="_blank"
                                                                    class="btn btn-icon btn-info"><i
                                                                        data-feather="layout"></i></a>
                                                            @endif

                                                            @if (empty($sk->arsip_id))
                                                                <a href="../arsip/{{ $sk->id }}/suratArsip"
                                                                    data-bs-toggle="tooltip" data-bs-placement="right"
                                                                    title="Buat Arsip" target="_blank"
                                                                    class="btn btn-icon btn-info"><i
                                                                        data-feather="folder-plus"></i></a>
                                                            @else
                                                                <a href="../arsip/{{ $sk->arsip_id }}/edit?read_only=1"
                                                                    data-bs-toggle="tooltip" data-bs-placement="right"
                                                                    title="Lihat Arsip" target="_blank"
                                                                    class="btn btn-icon btn-info"><i
                                                                        data-feather="archive"></i></a>
                                                            @endif
                                                        </div>
                                                    </td>
                                                @else
                                                    <td>
                                                        <a href="{{ url('surat/viewpdf', $sk->id) }}"
                                                            data-bs-toggle="tooltip" data-bs-placement="right"
                                                            title="Lihat Surat" target="_blank"
                                                            class="btn btn-icon btn-secondary"><i
                                                                data-feather="file"></i></a>
                                                    </td>
                                                @endif
                                            @else
                                                <td>{{ $sk->nomor_surat }}</td>
                                                <td>{{ $sk->nama_dokumen }}</td>
                                                <td>{{ $sk->tanggal }}</td>
                                                <td>{{ $sk->dari }}</td>
                                                <td>{{ $sk->tujuan_surat }}</td>
                                                @if (Auth::user()->level == 'Admin')
                                                    <td>
                                                        <!-- <div class="btn-group" role="group" aria-label="Basic example"> -->
                                                        <div class="demo-inline-spacing mb-2">
                                                            <button
                                                                onclick="window.location.href='/surat/{{ $sk->id }}/edit'"
                                                                data-bs-toggle="tooltip" data-bs-placement="right"
                                                                title="Edit Surat" type="button"
                                                                class="btn btn-icon btn-success ">
                                                                <i data-feather="edit"></i></button>
                                                            <a href="{{ url('surat/viewpdf', $sk->id) }}"
                                                                data-bs-toggle="tooltip" data-bs-placement="right"
                                                                title="Lihat Surat" target="_blank"
                                                                class="btn btn-icon btn-success"><i
                                                                    data-feather="file"></i></a>
                                                            <form id="hapus_{{ $sk->id }}"
                                                                action="/surat/{{ $sk->id }}" method="POST">
                                                                @csrf
                                                                @method('delete')
                                                                <button type="button" class="btn btn-icon btn-danger"
                                                                    data-bs-toggle="tooltip" data-bs-placement="right"
                                                                    title="Hapus Surat"
                                                                    onclick="notif_delete({{ $sk->id }})"
                                                                    value="delete">
                                                                    <i data-feather="trash"></i>
                                                                </button>
                                                            </form>
                                                            @if (empty($sk->ekspedisi_id))
                                                                <a href="../ekspedisi/{{ $sk->id }}/suratEkspedisi"
                                                                    data-bs-toggle="tooltip" data-bs-placement="right"
                                                                    title="Buat Ekspedisi" target="_blank"
                                                                    class="btn btn-icon btn-info"><i
                                                                        data-feather="book-open"></i></a>
                                                            @else
                                                                <a href="../ekspedisi/{{ $sk->ekspedisi_id }}/edit?read_only=1"
                                                                    data-bs-toggle="tooltip" data-bs-placement="right"
                                                                    title="Lihat Ekspedisi" target="_blank"
                                                                    class="btn btn-icon btn-info"><i
                                                                        data-feather="layout"></i></a>
                                                            @endif

                                                            @if (empty($sk->arsip_id))
                                                                <a href="../arsip/{{ $sk->id }}/suratArsip"
                                                                    data-bs-toggle="tooltip" data-bs-placement="right"
                                                                    title="Buat Arsip" target="_blank"
                                                                    class="btn btn-icon btn-info"><i
                                                                        data-feather="folder-plus"></i></a>
                                                            @else
                                                                <a href="../arsip/{{ $sk->arsip_id }}/edit?read_only=1"
                                                                    data-bs-toggle="tooltip" data-bs-placement="right"
                                                                    title="Lihat Arsip" target="_blank"
                                                                    class="btn btn-icon btn-info"><i
                                                                        data-feather="archive"></i></a>
                                                            @endif
                                                        </div>
                                                    </td>
                                                @else
                                                    <td>
                                                        <a href="{{ url('surat/viewpdf', $sk->id) }}"
                                                            data-bs-toggle="tooltip" data-bs-placement="right"
                                                            title="Lihat Surat" target="_blank"
                                                            class="btn btn-icon btn-secondary"><i
                                                                data-feather="file"></i></a>
                                                    </td>
                                                @endif
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
    </section>
@endsection

@section('vendor-script')
    {{-- vendor files TABLE --}}
    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.checkboxes.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/jszip.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/pdfmake.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/vfs_fonts.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.html5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.rowGroup.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/polyfill.min.js')) }}"></script>
    <!-- vendor files INPUT-->
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
@endsection

@section('page-script')
    <!-- Page js files -->
    <script src="{{ asset(mix('js/scripts/extensions/ext-component-sweet-alerts.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/extensions/ext-component-toastr.js')) }}"></script>

    <script>
        $(document).ready(function() {

            $('#suratKeluar').DataTable({
                searching: false,
                sorting: false,
            });

            @if ($message = Session::get('success'))
                toastr['success'](
                    '{!! $message !!}',
                    'Sukses', {
                        showDuration: 500
                    }
                );
            @endif

        });

        function notif_delete(id) {
            // console.log(id); 
            Swal.fire({
                title: 'Apa Anda Yakin ?',
                text: "Anda tidak bisa mengembalikan apa yang dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-outline-danger ms-1'
                },
                buttonsStyling: false
            }).then(function(result) {
                if (result.value) {
                    $('#hapus_' + id).submit();
                }
            });
        }

        Swal.fire({
            title: 'Apa Anda Yakin ?',
            text: "Anda tidak bisa mengembalikan apa yang dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus!',
            customClass: {
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-outline-danger ms-1'
            },
            buttonsStyling: false
        }).then(function(result) {
            if (result.value) {
                $('#hapus_' + id).submit();
            }
        });
    </script>
@endsection
