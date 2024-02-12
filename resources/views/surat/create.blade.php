@extends('layouts/contentLayoutMaster')

@section('title', 'Input Data Arsip')

@section('vendor-style')
  <!-- vendor css files -->
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
@endsection

@section('page-style')
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
@endsection

@section('content')
<!-- Basic multiple Column Form section start -->
<section id="multiple-column-form">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Data Inputan {{$jenis_surat}}</h4>
        </div>
        <div class="card-body">
          <form action="/surat/store" method="POST" class="form" id="jquery-val-form" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="jenis_surat" value="{{$jenis_surat}}">
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
                    required
                  />
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <label class="form-label" for="nama">Nama Dokumen</label>
                    <select name="dokumen_id" class="select2 form-select" id="nama" required>
                        <option value="">Pilih Dokumen</option>
                        @if($jenis_surat == "Surat Penting")
                          @foreach($dokumenPenting as $d)
                            <option value="{{$d->id}}">{{$d->nama_dokumen}}</option>
                          @endforeach
                        @elseif ($jenis_surat == "Surat Keluar")
                          @foreach($dokumenUmumKeluar as $d)
                            <option value="{{$d->id}}">{{$d->nama_dokumen}}</option>
                          @endforeach
                        @else
                        @foreach($dokumenUmumMasuk as $d)
                            <option value="{{$d->id}}">{{$d->nama_dokumen}}</option>
                          @endforeach
                        @endif
                    </select>
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
                    placeholder="Tahun-Bulan-Hari"
                    required />
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
                    placeholder="Tulis Disini"
                  />
                </div>
              </div>
              <div id="sifat" class="col-md-6 col-12">
                <div class="mb-1">
                <label class="form-label" for="sifat">Sifat</label>
                    <select name="sifat" class="select2 form-select" id="sifat">
                        <option value="">Sifat Dokumen</option>
                        <option value="Penting">Penting</option>
                        <option value="Biasa">Biasa</option>
                    </select>
                </div>
              </div>
 
              <!-- JENIS SURAT -->
              @php
              if($jenis_surat == "Surat Masuk"||$jenis_surat == "Surat Penting"){
                $jenis_surat = "Masuk";
              }else
              {
                $jenis_surat = "Keluar";
              }
              @endphp
                <input type="hidden" name="jenis_surat" value="{{$jenis_surat}}">

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
                <div class="mb-1" style="margin-top: 1.7em">
                <input
                    type="file"
                    id="doc"
                    class="form-control"
                    name="dokumen"
                    required
                  />
                </div>
              </div>
              <!-- KETERANGAN -->
              <div class="col-md-6 col-12">
                <div class="mb-1 mt-1 ">
                    <div class="form-floating">
                        <textarea
                        class="form-control"
                        name="keterangan"
                        placeholder="Tulis Keterangan Disini"
                        id="floatingTextarea2"
                        style="height: 100px"
                        ></textarea>
                    <label for="floatingTextarea2">Keterangan</label>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-12" style="margin-top: -0.7em;">
                <div class="alert alert-success" role="alert">
                  <div class="alert-body"><strong>NB :</strong> upload dokumen hanya dalam bentuk PDF</div>
                </div>
              </div>
              <input type="hidden" name="disposisi_id" id="disposisi_id">
              <input type="hidden" name="arsip_id" id="arsip_id">
              <input type="hidden" name="ekspedisi_id" id="ekspedisi_id">

              <div class="col-12">
                <button type="submit" class="btn btn-success me-1">Buat</button>
                <button type="reset" class="btn btn-secondary">Hapus</button>
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
  <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
@endsection

@section('page-script')
  <!-- Page js files -->
  <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
  <script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>
  <script src="{{ asset(mix('js/scripts/extensions/ext-component-toastr.js')) }}"></script>
  <script> 
    $(document).ready(function() {

      var jenis_surat = document.getElementById("jenis_surat").value;
      console.log(jenis_surat);
      if (jenis_surat == "Surat Penting") {
        document.getElementById("dari").hidden=true;
        document.getElementById("perihal").hidden=true;
        document.getElementById("tujuan").hidden=true;
        document.getElementById("sifat").hidden=true;
      };

      @if ($message = Session::get('succes'))
            toastr['success'](
                '{!! $message !!}',
                'Sukses',
                { showDuration: 500 }
            );
            @elseif (count($errors) > 0)
            @foreach ($errors->all() as $error)
                toastr['error'](
                    '{!! $error !!}', 'Error!', {
                        closeButton: true,
                        tapToDismiss: false,
                });
            @endforeach
            @endif
    });

  </script>
  <script>
    $('#jquery-val-form').validate({
    rules: {
      nomor:{
        required:true,
      },
      nama:{
        required:true,
      },
      doc:{
        required:true,
      }

    },
    message:{
      nomor:{
        required: "Isi Nomor Dokumen"
      },
      nama:{
        required : 'isi nama dokumen'
      },
      doc:{
        required: 'upload dokumen dulu'
      }
    }
  });
  </script>
@endsection
