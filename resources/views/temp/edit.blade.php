@extends('layouts/contentLayoutMaster')

@section('title', 'Input Data Arsip')

@section('vendor-style')
  <!-- vendor css files -->
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/file-uploaders/dropzone.min.css')) }}">
@endsection

@section('page-style')
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-file-uploader.css')) }}">
@endsection

@section('content')
<!-- Basic multiple Column Form section start -->
<section id="multiple-column-form">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Form Daftar Arsip</h4>
        </div>
        <div class="card-body">
          <form action="/arsip/{{$arsip->id}}" method="POST">
            @csrf
            @method('put')
            <div class="row">
                <div class="col-md-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="basic">Nomor Dokumen</label>
                       <input 
                       type="text" 
                       name="nomor_dokumen" 
                       id="basic"
                       class="form-control"
                       value="{{$arsip->nomor_dokumen}}"
                       >
                    </div>
                </div>
                <input type="hidden" name="nama_dokumen" value="{{$arsip->nama_dokumen}}">
                <div class="col-md-6 col-12">
                    <div class="mb-1">
                      <label class="form-label" for="kode-dokumen-column">Kode Arsip</label>
                        <input
                            type="text"
                            id="kode-column"
                            class="form-control"
                            placeholder="Masukkan kode Arsip"
                            name="kode_arsip"
                            value="{{$arsip->kode_arsip}}"
                        />
                    </div>
                  </div>
            <div class="col-md-6 col-12">
                <div class="mb-1">
                  <!-- <label class="form-label" for="tanggal-column">Tanggal</label> -->
                  <label class="form-label" for="fp-default">Tanggal Mulai Arsip</label>
                    <input type="text" 
                    name="tanggal_arsip" 
                    id="fp-default"
                    class="form-control flatpickr-basic" 
                    placeholder="Tahun-Bulan-Hari" 
                    value="{{$arsip->tanggal_arsip}}"
                    />
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <label class="form-label" for="masa-column">Masa Penyimpanan</label>
                  <input
                    type="text"
                    id="masa-column"
                    class="form-control"
                    name="masa"
                    value="{{$arsip->masa}}"
                    placeholder="Tulis Disini"
                  />
                </div>
              </div>
            </div>
            @if($read_only == false)
            <div class="col-12">
              <button type="submit" class="btn btn-success me-1">Perbarui Data</button>
            </div>
              @endif
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Basic Floating Label Form section end -->
@endsection


@section('vendor-script')
  <!-- vendor files -->
  <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/file-uploaders/dropzone.min.js')) }}"></script>
@endsection
@section('page-script')
  <!-- Page js files -->
  <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
  <script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>
  <script src="{{ asset(mix('js/scripts/forms/form-file-uploader.js')) }}"></script>
@endsection
