@extends('layouts/contentLayoutMaster')

@section('vendor-style')
{{-- vendor css files TABLE--}}
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">

@endsection

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
<link rel="stylesheet" href="{{asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css'))}}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">

@endsection

@section('title', 'Tabel Dokumen Penting')

@section('content')
<!-- Complex Headers -->
<section id="complex-header-datatable">
    <div class="row">
        <div class="card">
        <div class="col-12">
                <div class="card-header border-bottom p-1">
                    <div class="head-label">
                        @php
                            $jenis_surat="Surat Penting";
                        @endphp
                        <button class="btn btn-relief-success round waves-effect" type="button" onclick="window.location.href='/surat/create/{{$jenis_surat}}'">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus me-50 font-small-4">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                Dokumen Penting
                            </span>
                        </button>
                    </div>
                </div>
              
                <div class="card-datatable" style="margin: 5px ;">
                    <table id="suratPenting" class="dt-multilingual table">
                        <thead>
                            <tr>
                                @if(Auth::user()->username == 'Ketua PI RJ' || Auth::user()->username == 'Admin') 
                                <th>Institusi</th>
                                <th>Nomor Dokumen</th>
                                <th>Nama Dokumen</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                                @else
                                <th>Nomor Dokumen</th>
                                <th>Nama Dokumen</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($suratPenting as $s)
                          <tr>
                            @if(Auth::user()->username == 'Admin')
                            <td>{{$s->institusi}}</td>
                            <td>{{$s->nomor_surat}}</td>
                            <td>{{$s->nama_dokumen}}</td>
                            <td>{{$s->keterangan}}</td>
                            <td>
                                <!-- <div class="btn-group" role="group" aria-label="Basic example"> -->
                                    <div class="demo-inline-spacing mb-2">
                                        <button onclick="window.location.href='/surat/{{$s->id}}/edit'"  data-bs-toggle="tooltip" data-bs-placement="right"
                                        title="Edit Surat" type="button" class="btn btn-icon btn-success ">
                                            <i data-feather="edit"></i></button>
                                        <a href="{{url ('surat/viewpdf', $s->id)}}" data-bs-toggle="tooltip" data-bs-placement="right"
                                        title="Lihat Surat" target="_blank" class="btn btn-icon btn-success"><i data-feather="file"></i></a>
                                         <form id="hapus_{{$s->id}}" action="/surat/{{ $s->id }}" method="POST">
                                          @csrf
                                          @method('delete')
                                          {{-- <button type="button" class="btn btn-icon btn-danger" id="confirmText" value="delete"> --}}
                                          <button type="button" class="btn btn-icon btn-danger"  data-bs-toggle="tooltip" data-bs-placement="right"
                                            title="Hapus Surat" onclick="notif_delete({{$s->id}})" value="delete">
                                              <i data-feather="trash"></i>
                                          </button>
                                        </form>
                                        @if(empty($s->arsip_id))
                                        <a href="../arsip/{{$s->id}}/suratArsip" target="_blank"  data-bs-toggle="tooltip" data-bs-placement="right"
                                        title="Buat Arsip" class="btn btn-icon btn-info"><i data-feather="folder"></i></a>
                                        @else
                                        <a href="../arsip/{{$s->arsip_id}}/edit?read_only=1" data-bs-toggle="tooltip" data-bs-placement="right"
                                        title="Lihat Arsip"  target="_blank" class="btn btn-icon btn-info"><i data-feather="archive"></i></a>
                                        @endif
                                        
                                    </div>
                            </td>
                            @else
                            <td>{{$s->nomor_surat}}</td>
                            <td>{{$s->nama_dokumen}}</td>
                            <td>{{$s->keterangan}}</td>
                            <td>
                                <!-- <div class="btn-group" role="group" aria-label="Basic example"> -->
                                    <div class="demo-inline-spacing mb-2">
                                        <button onclick="window.location.href='/surat/{{$s->id}}/edit'"  data-bs-toggle="tooltip" data-bs-placement="right"
                                        title="Edit Surat"  type="button" class="btn btn-icon btn-success ">
                                            <i data-feather="edit"></i></button>
                                        <a href="{{url ('surat/viewpdf', $s->id)}}" data-bs-toggle="tooltip" data-bs-placement="right"
                                        title="Lihat Surat" target="_blank" class="btn btn-icon btn-info"><i data-feather="file"></i></a>
                                        <form id="hapus_{{$s->id}}" action="/surat/{{ $s->id }}" method="POST">
                                          @csrf
                                          @method('delete')
                                          <button type="button"  data-bs-toggle="tooltip" data-bs-placement="right"
                                            title="Hapus Surat" class="btn btn-icon btn-danger" onclick="notif_delete({{$s->id}})" value="delete">
                                              <i data-feather="trash"></i>
                                          </button>
                                        </form>
                                        @if(empty($s->arsip_id))
                                        <a href="../arsip/{{$s->id}}/suratArsip" data-bs-toggle="tooltip" data-bs-placement="right"
                                        title="Buat Arsip"  target="_blank" class="btn btn-icon btn-warning"><i data-feather="folder"></i></a>
                                        @else
                                        <a href="../arsip/{{$s->arsip_id}}/edit?read_only=1" data-bs-toggle="tooltip" data-bs-placement="right"
                                        title="Lihat Arsip"  target="_blank" class="btn btn-icon btn-warning"><i data-feather="archive"></i></a>
                                        @endif
                                       
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
{{-- vendor files TABLE--}}
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
<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
<script src="{{ asset(mix('js/scripts/extensions/ext-component-sweet-alerts.js'))}}"></script>
@endsection

@section('page-script')

<!-- Page js files -->
<script>
     $(document).ready(function() {

        $('#suratPenting').DataTable({
            sorting: false,
        });
       
        @if ($message = Session::get('success'))
          toastr['success'](
            '{!! $message !!}',
            'Sukses',
            {showDuration: 500}
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
                    $('#hapus_'+id).submit();
                }
            });
          }
</script>
@endsection
