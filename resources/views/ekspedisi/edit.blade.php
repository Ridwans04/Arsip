@extends('layouts/contentLayoutMaster')

@section('title', 'Edit Data Rekap Ekspedisi')

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
          <h4 class="card-title">Form Edit Rekap Ekspedisi </h4>
        </div>
        <div class="card-body">
          <form action="/ekspedisi/{{$ekspedisi->id}}" method="POST">
            @csrf
            @method('put')
            <div class="row">
            <div class="col-md-6 col-12">
                <div class="mb-1">
                  <!-- <label class="form-label" for="tanggal-column">Tanggal</label> -->
                  <label class="form-label" for="fp-default">Tanggal Kirim</label>
                    <input type="text" 
                    value="{{$ekspedisi->tanggal_kirim}}" 
                    name="tanggal_kirim" 
                    id="fp-default" 
                    class="form-control flatpickr-basic" 
                    placeholder="Tahun-Bulan-Hari" />
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <label class="form-label" for="nomor-dokumen-column">Nomor Surat</label>
                  <input
                    type="text"
                    id="nomor-dokumen-column"
                    class="form-control"
                    value="{{$ekspedisi->nomor_surat}}"
                    placeholder="Masukkan Nomor Surat"
                    name="nomor_surat"
                  />
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <!-- <label class="form-label" for="tanggal-column">Tanggal</label> -->
                  <label class="form-label" for="fp-default">Tanggal Surat</label>
                    <input type="text" 
                    name="tanggal_surat" 
                    id="fp-default" 
                    value="{{$ekspedisi->tanggal_surat}}"
                    class="form-control flatpickr-basic" 
                    placeholder="Tahun-Bulan-Hari" />
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <label class="form-label" for="perihal-column">Perihal</label>
                  <input
                    type="text"
                    id="perihal-column"
                    class="form-control"
                    name="perihal"
                    value="{{$ekspedisi->perihal}}"
                    placeholder="Tulis Disini"
                  />
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <label class="form-label" for="perihal-column">Nama Penerima</label>
                  <input
                    type="text"
                    id="perihal-column"
                    class="form-control"
                    name="nama_penerima"
                    value="{{$ekspedisi->nama_penerima}}"
                    placeholder="Tulis Disini"
                  />
                </div>
              </div>
              {{-- <input type="text" name="institusi" value="{{$ekspedisi->institusi}}" id=""> --}}
              <input type="hidden" name="jenis" value="{{$ekspedisi->jenis}}">
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
