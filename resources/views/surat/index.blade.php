@extends('layouts/contentLayoutMaster')

@section('vendor-style')
{{-- vendor css files TABLE--}}
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')) }}">
{{-- Vendor Css Extension --}}
<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
@endsection

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
@endsection

@section('title', 'Tabel Surat Masuk dan Keluar')

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
                            $jenis_surat="Surat Masuk";
                        @endphp
                        <button class="btn btn-relief-secondary round waves-effect" type="button" onclick="window.location.href='/surat/create/{{$jenis_surat}}'">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus me-50 font-small-4">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                Surat Masuk
                            </span>
                        </button>
                    </div>
                </div>
                @else
                @endif

                <div class="card-datatable"  style="margin:5px;">
                    <div class="card-body">
                        <form action="#" method="POST" class="form" id="jquery-val-form" enctype="multipart/form-data">
                          @csrf
                          <div class="row">
                            <div class="col-md-6 col-12">
                              <div class="mb-1">
                                <label class="form-label" for="nomor">Nomor Dokumen</label>
                                <input
                                  type="text"
                                  id="nomor"
                                  class="form-control"
                                  placeholder="Masukkan Nomor dokumen"
                                  name="nomor_surat"
                                />
                              </div>
                            </div>
                             <!-- JENIS SURAT -->
                            
                            <div class="col-md-6 col-12">
                              <div class="mb-1">
                                <!-- <label class="form-label" for="tanggal-column">Tanggal</label> -->
                                <label class="form-label" for="fp">Tanggal</label>
                                  <input 
                                  type="text" 
                                  name="tanggal" 
                                  id="fp" 
                                  class="form-control flatpickr-basic" 
                                  placeholder="Tahun-Bulan-Hari"/>
                              </div>
                            </div>
                            <div id="dari" class="col-md-6 col-12">
                              <div class="mb-1">
                                <label class="form-label" for="dari">Dari</label>
                                <input
                                  type="text"
                                  id="dri"
                                  class="form-control"
                                  name="dari"
                                  placeholder="Tulis Disini"
                                />
                              </div>
                            </div>
                            <div id="tujuan" class="col-md-6 col-12">
                              <div class="mb-1">
                                <label class="form-label" for="tujuan">Tujuan Surat</label>
                                <input
                                  type="text"
                                  id="tjn"
                                  class="form-control"
                                  name="tujuan_surat"
                                  value="{{ $params['tujuan_surat'] ?? '' }}"
                                  placeholder="Tulis Disini"
                                />
                              </div>
                            </div>
               
                            <div id="perihal" class="col-md-6 col-12">
                              <div class="mb-1">
                                <label class="form-label" for="perihal-column">Perihal</label>
                                <input
                                  type="text"
                                  id="perihal-column"
                                  class="form-control"
                                  name="perihal"
                                  placeholder="Tulis Disini"
                                />
                              </div>
                            </div>
                            
                            <div class="col-md-6 col-12">
                              <button type="submit" class="btn btn-success me-1">Cari</button>
                            </div>
                          </div>
                        </form>
                      </div>
                    {{-- surat masuk --}}
                    <table id="suratMasuk" class="dt-multilingual table">
                        <thead>
                            <tr>
                                @if(Auth::user()->username == 'Admin' || Auth::user()->username == 'Ketua PI RJ') 
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
                          @foreach($suratmasuk as $sm)
                          <tr>
                            @if(Auth::user()->username == 'Admin' || Auth::user()->username == 'Ketua PI RJ')
                            <td>{{$sm->institusi}}</td>
                            <td>{{$sm->nomor_surat}}</td>
                            <td>{{$sm->nama_dokumen}}</td>
                            <td>{{$sm->tanggal}}</td>
                            <td>{{$sm->dari}}</td>
                            <td>{{$sm->tujuan_surat}}</td>
                            @if (Auth::user()->level == 'Admin')
                            <td>
                                <!-- <div class="btn-group" role="group" aria-label="Basic example"> -->
                                    <div class="demo-inline-spacing mb-2">
                                        <button onclick="window.location.href='/surat/{{$sm->id}}/edit'" data-bs-toggle="tooltip" data-bs-placement="right"
                                        title="Edit Surat" type="button" class="btn btn-icon btn-success ">
                                            <i data-feather="edit"></i></button>
                                        <form action="/surat/{{$sm->id}}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-icon btn-secondary" data-bs-toggle="tooltip" data-bs-placement="right"
                                        title="Hapus Surat" type="submit" value="Delete">
                                            <i data-feather="delete" ></i>
                                        </button>
                                        </form>
                                        <a href="{{url ('surat/viewpdf', $sm->id)}}" target="_blank" data-bs-toggle="tooltip" data-bs-placement="right"
                                        title="Lihat Surat" class="btn btn-icon btn-success"><i data-feather="file"></i></a>
                                        @if(empty($sm->disposisi_id))
                                            <a href="disposisi/create" target="_blank" class="btn btn-icon btn-success" data-bs-toggle="tooltip" data-bs-placement="right"
                                        title="Buat Disposisi" ><i data-feather="file"></i></a>
                                        
                                        @else
                                        <a href="disposisi/{$sm->disposisi_id}/edit?read_only=1" target="_blank" class="btn btn-icon btn-success" ><i data-feather="file"></i></a>
                                        
                                        @endif
                                        
                                    </div>
                            </td>
                            @else
                            <td>
                                <a href="{{url ('surat/viewpdf', $sm->id)}}" data-bs-toggle="tooltip" data-bs-placement="right"
                                    title="Lihat Surat" target="_blank" class="btn btn-icon btn-success"><i data-feather="file"></i></a>
                            </td>
                            @endif
                            @else
                            <td>{{$sm->nomor_surat}}</td>
                            <td>{{$sm->nama_dokumen}}</td>
                            <td>{{$sm->tanggal}}</td>
                            <td>{{$sm->dari}}</td>
                            <td>{{$sm->tujuan_surat}}</td>
                            @if (Auth::user()->level == 'Admin')
                            <td>
                                <!-- <div class="btn-group" role="group" aria-label="Basic example"> -->
                                    <div class="demo-inline-spacing mb-2">
                                        <button onclick="window.location.href='/surat/{{$sm->id}}/edit'" type="button" class="btn btn-icon btn-success ">
                                            <i data-feather="edit"></i></button>
                                        <form action="/surat/{{$sm->id}}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-icon btn-secondary" type="submit" value="Delete">
                                            <i data-feather="delete" ></i>
                                        </button>
                                        </form>
                                        <a href="{{url ('surat/viewpdf', $sm->id)}}" target="_blank" class="btn btn-icon btn-success"><i data-feather="file"></i></a>
                                        @if(empty($sm->disposisi_id))
                                            <a href="../disposisi/create" target="_blank" class="btn btn-icon btn-success" ><i data-feather="file"></i></a>
                                        
                                        @else
                                        <a href="../disposisi/{{$sm->disposisi_id}}/edit?read_only=1" target="_blank" class="btn btn-icon btn-success" ><i data-feather="file"></i></a>
                                        
                                        @endif
                                        
                                    </div>
                            </td>
                            @else
                            <td>
                                <a href="{{url ('surat/viewpdf', $sm->id)}}" target="_blank" class="btn btn-icon btn-success"><i data-feather="file"></i></a>
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
    </div>
</section>
<section id="complex-header-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                @if (Auth::user()->level == 'Admin')
                <div class="card-header border-bottom p-1">
                    <div class="head-label">
                        @php
                            $jenis_surat="Surat Keluar";
                        @endphp
                       
                        <button class="btn btn-relief-success round waves-effect" type="button" onclick="window.location.href='/surat/create/{{$jenis_surat}}'">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus me-50 font-small-4">
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
                    <table id="suratKeluar" class="dt-multilingual table">
                        <thead>
                            <tr>
                                @if(Auth::user()->username == 'Admin' || Auth::user()->username == 'Ketua PI RJ')
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
                          @foreach($suratkeluar as $sk)
                          <tr>
                            @if(Auth::user()->username == 'Admin' || Auth::user()->username == 'Ketua PI RJ')
                            <td>{{$sk->institusi}}</td>
                            <td>{{$sk->nomor_surat}}</td>
                            <td>{{$sk->nama_dokumen}}</td>
                            <td>{{$sk->tanggal}}</td>
                            <td>{{$sk->dari}}</td>
                            <td>{{$sk->tujuan_surat}}</td>
                            @if (Auth::user()->level == 'Admin')
                            <td>
                                <!-- <div class="btn-group" role="group" aria-label="Basic example"> -->
                                <div class="demo-inline-spacing mb-2">
                                    <button onclick="window.location.href='/surat/{{$sk->id}}/edit'" type="button" class="btn btn-icon btn-secondary ">
                                        <i data-feather="edit"></i></button>
                                    <form action="/surat/{{$sk->id}}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-icon btn-success" type="submit" value="Delete">
                                        <i data-feather="delete" ></i>
                                    </button>
                                    </form>
                                    <a href="{{url ('surat/viewpdf', $sk->id)}}" target="_blank" class="btn btn-icon btn-secondary"><i data-feather="file"></i></a>
                                </div>
                            </td>
                            @else
                            <td>
                            <a href="{{url ('surat/viewpdf', $sk->id)}}" target="_blank" class="btn btn-icon btn-secondary"><i data-feather="file"></i></a>
                            </td>
                            @endif
                            @else
                            <td>{{$sk->nomor_surat}}</td>
                            <td>{{$sk->nama_dokumen}}</td>
                            <td>{{$sk->tanggal}}</td>
                            <td>{{$sk->dari}}</td>
                            <td>{{$sk->tujuan_surat}}</td>
                            @if (Auth::user()->level == 'Admin')
                            <td>
                                <!-- <div class="btn-group" role="group" aria-label="Basic example"> -->
                                <div class="demo-inline-spacing mb-2">
                                    <button onclick="window.location.href='/surat/{{$sk->id}}/edit'" type="button" class="btn btn-icon btn-secondary ">
                                        <i data-feather="edit"></i></button>
                                    <form action="/surat/{{$sk->id}}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-icon btn-success" type="submit" value="Delete">
                                        <i data-feather="delete" ></i>
                                    </button>
                                    </form>
                                    <a href="{{url ('surat/viewpdf', $sk->id)}}" target="_blank" class="btn btn-icon btn-secondary"><i data-feather="file"></i></a>
                                </div>
                            </td>
                            @else
                            <td>
                            <a href="{{url ('surat/viewpdf', $sk->id)}}" target="_blank" class="btn btn-icon btn-secondary"><i data-feather="file"></i></a>
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
<!--/ Complex Headers -->
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
<!-- vendor files INPUT-->
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>

@endsection

@section('page-script')
<!-- Page js files -->
<script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
<script src="{{ asset(mix('js/scripts/forms/form-repeater.js')) }}"></script>
<script src="{{ asset(mix('js/scripts/extensions/ext-component-toastr.js')) }}"></script>

<script>
    $(document).ready(function() {

        $('#suratMasuk').DataTable();
        $('#suratKeluar').DataTable();

        @if ($message = Session::get('success'))
          toastr['success'](
            '{!! $message !!}',
            'Sukses',
            {showDuration: 500}
          );
         @endif
    });
</script>
@endsection
