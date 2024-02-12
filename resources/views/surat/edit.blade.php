@extends('layouts/contentLayoutMaster')

@section('title', 'Edit Data Surat')

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
          <h4 class="card-title">Form Edit Surat</h4>
        </div>
        <!-- <h1>{{$surat}}</h1> -->
        <div class="card-body">
          <form action="/surat/{{$surat->id}}" method="POST" class="form" enctype="multipart/form-data">
            @csrf
            @method('put')
            <input type="hidden" id="jenis_surat" value="{{$surat->jenis_surat}}">
            <div class="row">
              <input type="hidden" name="institusi" value="{{$surat->institusi}}">
              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <label class="form-label" for="nomor-dokumen-column">Nomor Dokumen</label>
                  <input
                    type="text"
                    id="nomor-dokumen-column"
                    class="form-control"
                    placeholder="Masukkan Nomor dokumen"
                    name="nomor_surat"
                    value="{{$surat->nomor_surat}}"
                  />
                </div>
              </div>
              <input type="hidden" id="klasifikasi" name="klasifikasi" value="{{$surat->klasifikasi}}">
              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <label class="form-label" for="nama-column">Nama Dokumen</label>
                    <input 
                    type="text" 
                    id="nama-column"
                    name="nama_dokumen"
                    class="form-control" 
                    value="{{$surat->nama_dokumen}}">
                </div>
              </div>
               <!-- JENIS SURAT -->
              
              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <!-- <label class="form-label" for="tanggal-column">Tanggal</label> -->
                  <label class="form-label" for="fp-default">Tanggal</label>
                    <input type="text" 
                    name="tanggal" 
                    id="fp-default" 
                    class="form-control flatpickr-basic" 
                    placeholder="Tahun-Bulan-Hari" 
                    value="{{$surat->tanggal}}"
                    />
                </div>
              </div>
              <div id="dari" class="col-md-6 col-12">
                <div class="mb-1">
                  <label class="form-label" for="dari">Dari</label>
                  <input
                    type="text"
                    id="dari"
                    class="form-control"
                    name="dari"
                    value="{{$surat->dari}}"
                    placeholder="Tulis Disini"
                  />
                </div>
              </div>
              <div id="tujuan" class="col-md-6 col-12">
                <div class="mb-1">
                  <label class="form-label" for="tujuan">Tujuan Surat</label>
                  <input
                    type="text"
                    id="tujuan"
                    class="form-control"
                    name="tujuan_surat"
                    value="{{$surat->tujuan_surat}}"
                    placeholder="Tulis Disini"
                  />
                </div>
              </div>
              <div id="sifat" class="col-md-6 col-12">
                <div class="mb-1">
                <label class="form-label" for="sifat">Sifat</label>
                    <select name="sifat" class="select2 form-select" id="sifat">
                        <option value="">Sifat Dokumen</option>
                        <option value="Penting" @if($surat->sifat == 'Penting') selected @endif>Penting</option>
                        <option value="Biasa"  @if($surat->sifat == 'Biasa') selected @endif>Biasa</option>
                    </select>
                </div>
              </div>
              <div id="perihal" class="col-md-6 col-12">
                <div class="mb-1">
                  <label class="form-label" for="perihal">Perihal</label>
                  <input
                    type="text"
                    id="perihal"
                    class="form-control"
                    name="perihal"
                    value="{{$surat->perihal}}"
                    placeholder="Tulis Disini"
                  />
                </div>
              </div>

              <!-- UPLOAD FILE -->
              <div class="col-md-6 col-12">
                <div class="mt-2">
                <input
                    type="file"
                    id="doc"
                    class="form-control"
                    name="dokumen"
                    value="{{$surat->dokumen}}"
                  />
                </div>
              </div>

              <!-- KETERANGAN -->
              <div class="col-md-6 col-12">
                <div class="mb-1 mt-1">
                    <div class="form-floating">
                        <textarea
                        class="form-control"
                        name="keterangan"
                        placeholder="Tulis Keterangan Disini"
                        id="floatingTextarea2"
                        style="height: 100px"
                        >{{$surat->keterangan}}</textarea>
                    <label for="floatingTextarea2">Keterangan</label>
                    </div>
                </div>
                <input type="hidden" name="disposisi_id" id="disposisi_id" value="{{$surat->disposisi_id}}">
              </div>
              <div class="col-md-6 col-12" style="margin-top: -0.7em;">
                <div class="alert alert-success" role="alert">
                  <div class="alert-body"><strong>File yang diupload :</strong> {{$surat->dokumen}}</div>
                </div>
              </div>
              <div class="col-12">
                <button type="submit" class="btn btn-success me-1">Perbarui Data</button>
              </div>
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
  <script> 
    $(document).ready(function() {

      var klasifikasi = document.getElementById("klasifikasi").value;
      console.log(klasifikasi);
      if (klasifikasi == "Penting") {
        document.getElementById("dari").hidden=true;
        document.getElementById("perihal").hidden=true;
        document.getElementById("tujuan").hidden=true;
        document.getElementById("sifat").hidden=true;
      }
    });
  </script>
@endsection
