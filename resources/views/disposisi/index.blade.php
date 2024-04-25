@extends('layouts/contentLayoutMaster')

@section('vendor-style')
    {{-- vendor css files TABLE --}}
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
@endsection

@section('page-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
@endsection

@section('title', 'Tabel Lembar Disposisi')

@section('content')
    <!-- Complex Headers -->
    <section id="complex-header-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-datatable" style="font-size:medium; margin: 5px; padding: 2px">
                        <table id="disposisi" class="dt-multilingual table">
                            <thead>
                                <tr>
                                    @if (Auth::user()->username == 'Admin' || Auth::user()->username == 'Ketua PI RJ')
                                        <th>Institusi</th>
                                    @endif
                                    <th>Nomor Surat</th>
                                    <th>Tanggal Terima</th>
                                    <th>Tujuan</th>
                                    <th>Catatan</th>
                                    <th>Tindak Lanjut</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                            </thead>
                            <tbody>
                                @foreach ($disposisi as $d)
                                    <tr>
                                        {{-- untuk username admin & ketua --}}
                                        @if (Auth::user()->username == 'Admin' || Auth::user()->username == 'Ketua PI RJ')
                                            <td>{{ $d->institusi }}</td>
                                        @endif
                                        <td>{{ $d->nomor_surat }}</td>
                                        <td>{{ $d->tanggal_terima }}</td>
                                        <td>{{ $d->tujuan }}</td>
                                        <td>{{ $d->catatan }}</td>
                                        <td>{{ $d->tindak_lanjut }}</td>
                                        <td>{{ $d->keterangan }}</td>
                                        @if (Auth::user()->level == 'Admin')
                                            <td>
                                                <!-- <div class="btn-group" role="group" aria-label="Basic example"> -->
                                                <div class="demo-inline-spacing" role="group" style="">
                                                    <button
                                                        onclick="window.location.href='/disposisi/{{ $d->id }}/edit'"
                                                        data-bs-toggle="tooltip" data-bs-placement="right"
                                                        title="Edit disposisi" type="button"
                                                        class="btn btn-icon btn-success ">
                                                        <i data-feather="edit"></i>
                                                    </button>
                                                    <form id="hapus_{{ $d->id }}"
                                                        action="/surat/{{ $d->id }}" method="POST">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="button" class="btn btn-icon btn-danger"
                                                            data-bs-toggle="tooltip" data-bs-placement="right"
                                                            title="Hapus Disposisi"
                                                            onclick="notif_delete({{ $d->id }})" value="delete">
                                                            <i data-feather="trash"></i>
                                                        </button>
                                                    </form>
                                                    {{-- <a href="{{url ('disposisi/lihatfoto', $d->id)}}" target="_blank" class="btn btn-primary btn-sm">Detail</a> --}}
                                                    <div class="scrolling-inside-modal">
                                                        <!-- Button trigger modal -->
                                                        <button type="button" class="btn btn-icon btn-success"
                                                            title = "Lihat File Disposisi" data-bs-toggle="modal"
                                                            data-bs-target="#dispo{{ $d->id }}">
                                                            <i data-feather="file"></i>
                                                        </button>

                                                        <!-- MODAL GAMBAR DISPOSISI-->
                                                        <div class="modal fade" id="dispo{{ $d->id }}"
                                                            tabindex="-1" aria-labelledby="exampleModalScrollableTitle"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-scrollable">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title"
                                                                            id="exampleModalScrollableTitle">Dokumen
                                                                            Disposisi</h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        {{-- ambil gambar dari public --}}
                                                                        <img class="img-fluid" alt=""
                                                                            src="{{ asset('/disposisi/' . $d->institusi . '/' . $d->surat_id . '/' . $d->dokumen) }}"
                                                                            width="100%">

                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-primary"
                                                                            data-bs-dismiss="modal">Selesai</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </td>
                                        @else
                                            <td>
                                                <div class="scrolling-inside-modal">
                                                    <!-- Button trigger modal -->
                                                    <button type="button" title = "Lihat File Disposisi"
                                                        class="btn btn-icon btn-success" data-bs-toggle="modal"
                                                        data-bs-target="#dispo{{ $d->id }}">
                                                        <i data-feather="file"></i>
                                                    </button>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="dispo{{ $d->id }}" tabindex="-1"
                                                        aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">

                                                        <div class="modal-dialog modal-dialog-scrollable">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="exampleModalScrollableTitle">Dokumen
                                                                        Disposisi</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    {{-- ambil gambar dari public --}}
                                                                    <img class="img-fluid" alt=""
                                                                        src="{{ asset('disposisi/' . $d->institusi . '/' . $d->surat_id . '/' . $d->dokumen) }}"
                                                                        width="100%">

                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-primary"
                                                                        data-bs-dismiss="modal">Selesai</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
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
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/polyfill.min.js')) }}"></script>
@endsection


@section('page-script')
    <!-- Page js files -->
    <script src="{{ asset(mix('js/scripts/components/components-modals.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/extensions/ext-component-toastr.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/extensions/ext-component-sweet-alerts.js')) }}"></script>

    <script>
        $(document).ready(function() {
            $('#disposisi').DataTable();

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
    </script>
@endsection
