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
{{-- Vendor Css files INPUT --}}
<link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
@endsection

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
<link rel="stylesheet" href="{{asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css'))}}">
@endsection

@section('title', 'Catatan Ekspedisi')

@section('content')
<section id="complex-header-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                @if (Auth::user()->level == 'Admin')
                <div class="card-header border-bottom p-1">
                    <div class="head-label">
                        <button class="btn btn-relief-success round waves-effect " type="button" onclick="window.location.href='/ekspedisi/create'">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus me-50 font-small-4">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                               Tambah Data
                            </span>
                        </button>
                    </div>
                </div>
                @else
                @endif

                    <div class="card-body mt-2">
                        <form action="#" method="POST" class="form">
                          @csrf
                          <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                  <!-- <label class="form-label" for="tanggal-column">Tanggal</label> -->
                                  <label class="form-label" for="tglkir">Tanggal Kirim</label>
                                    <input 
                                    type="text" 
                                    name="tanggal_kirim" 
                                    id="tglkir" 
                                    value="{{ $params['tanggal_kirim'] ?? '' }}"
                                    class="form-control flatpickr-basic" 
                                    placeholder="Tahun-Bulan-Hari"/>
                                </div>
                              </div>
                            <div class="col-md-6 col-12">
                              <div class="mb-1">
                                <!-- <label class="form-label" for="tanggal-column">Tanggal</label> -->
                                <label class="form-label" for="tglsrt">Tanggal Surat</label>
                                  <input 
                                  type="text" 
                                  name="tanggal_surat" 
                                  id="tglsrt" 
                                  value="{{ $params['tanggal_surat'] ?? '' }}"
                                  class="form-control flatpickr-basic" 
                                  placeholder="Tahun-Bulan-Hari"/>
                              </div>
                            </div>
                            <div class="col-md-6 col-12">
                              <div class="mb-1">
                                <label class="form-label" for="nomer">Nomor Surat</label>
                                <input
                                  type="text"
                                  id="nomer"
                                  class="form-control"
                                  name="nomor_surat"
                                  value="{{ $params['nomor_surat'] ?? '' }}"
                                  placeholder="Tulis Disini"
                                />
                              </div>
                            </div>
                            <div class="col-md-6 col-12">
                              <div class="mb-1">
                                <label class="form-label" for="nmpnrm">Nama Penerima</label>
                                <input
                                  type="text"
                                  id="nmprn"
                                  class="form-control"
                                  name="nama_penerima"
                                  value="{{ $params['nama_penerima'] ?? '' }}"
                                  placeholder="Tulis Disini"
                                />
                              </div>
                            </div>
               
                            <div class=" col-12">
                              <button type="submit" class="btn btn-icon btn-danger me-1">
                                <i data-feather="search" ></i>
                              </button>
                            </div>
                          </div>
                        </form>
                      </div>

                <div class="card-datatable" style=" margin: 5px;">
                    <table id="ekspedisi" class="dt-multilingual table">
                        <thead>
                            <tr> 
                                @if(Auth::user()->username == 'Admin' || Auth::user()->username == 'Ketua PI RJ')
                                <th>Institusi</th>
                                <th>Tanggal Kirim</th>
                                <th>Nomor Surat</th>
                                <th>Tanggal Surat</th>
                                <th>Perihal</th>
                                <th>Nama Penerima</th>
                                <th>Jenis</th>
                                @if (Auth::user()->level == 'Admin')
                                <th>Aksi</th>
                                @endif
                                {{-- username selain ketua dan admin --}}
                                @else
                                <th>Tanggal Kirim</th>
                                <th>Nomor Surat</th>
                                <th>Tanggal Surat</th>
                                <th>Perihal</th>
                                <th>Nama Penerima</th>
                                <th>Jenis</th>
                                @if (Auth::user()->level == 'Admin')
                                <th>Aksi</th>
                                @endif
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($ekspedisi as $e)
                          <tr>
                            @if(Auth::user()->username == 'Admin' || Auth::user()->username == 'Ketua PI RJ')
                            <td>{{$e->institusi}}</td>
                            <td>{{$e->tanggal_kirim}}</td>
                            <td>{{$e->nomor_surat}}</td>
                            <td>{{$e->tanggal_surat}}</td>
                            <td>{{$e->perihal}}</td>
                            <td>{{$e->nama_penerima}}</td>
                            <td>{{$e->jenis}}</td>
                            @if (Auth::user()->level == 'Admin')
                            <td>
                                <!-- <div class="btn-group" role="group" aria-label="Basic example"> -->
                                <div class="demo-inline-spacing mb-2">
                                    <button onclick="window.location.href='/ekspedisi/{{$e->id}}/edit'" data-bs-toggle="tooltip" data-bs-placement="right"
                                    title="Edit Ekspedisi" type="button" class="btn btn-icon btn-success">
                                            <i data-feather="edit"></i></button>
                                    <form id="hapus_{{$e->id}}" action="/surat/{{$e->id}}" method="POST">
                                      @csrf
                                      @method('delete')
                                      <button type="button" class="btn btn-icon btn-danger" data-bs-toggle="tooltip" data-bs-placement="right"
                                    title="Hapus Ekspedisi" onclick="notif_delete({{$e->id}})" value="delete">
                                          <i data-feather="trash"></i>
                                      </button>
                                   </form>
                                </div>
                            </td>
                            @else
                            @endif
                            {{-- username selain admin dan ketua --}}
                            @else
                            <td>{{$e->tanggal_kirim}}</td>
                            <td>{{$e->nomor_surat}}</td>
                            <td>{{$e->tanggal_surat}}</td>
                            <td>{{$e->perihal}}</td>
                            <td>{{$e->nama_penerima}}</td>
                            <td>{{$e->jenis}}</td>
                            @if (Auth::user()->level == 'Admin')
                            <td>
                                <!-- <div class="btn-group" role="group" aria-label="Basic example"> -->
                                <div class="demo-inline-spacing mb-2">
                                    <button onclick="window.location.href='/ekspedisi/{{$e->id}}/edit'" data-bs-toggle="tooltip" data-bs-placement="right"
                                    title="Edit Ekspedisi" type="button" class="btn btn-icon btn-success">
                                            <i data-feather="edit"></i></button>
                                     <form id="hapus_{{$e->id}}" action="/surat/{{$e->id}}" method="POST">
                                      @csrf
                                      @method('delete')
                                      <button type="button" class="btn btn-icon btn-danger" data-bs-toggle="tooltip" data-bs-placement="right"
                                    title="Hapus Ekspedisi" onclick="notif_delete({{$e->id}})" value="delete">
                                          <i data-feather="trash"></i>
                                      </button>
                                   </form>
                                </div>
                            </td>
                            @else
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
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>

@endsection

@section('page-script')
  {{-- Page js files --}}
  <script src="{{ asset(mix('js/scripts/tables/table-datatables-advanced.js')) }}"></script>
  <script src="{{ asset(mix('js/scripts/extensions/ext-component-toastr.js')) }}"></script>
<script src="{{ asset(mix('js/scripts/extensions/ext-component-sweet-alerts.js'))}}"></script>
  <script>
    $(document).ready(function() {

        $('#ekspedisi').DataTable({
          searching: false,
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

