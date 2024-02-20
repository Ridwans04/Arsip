@extends('layouts/contentLayoutMaster')

@section('title', 'Input Data Arsip')

@section('vendor-style')
  <!-- vendor css files -->
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/file-uploaders/dropzone.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
@endsection

@section('page-style')
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-file-uploader.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
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
          <form action="/arsip/shop" id="jquery-val-form"  method="POST">
            @csrf
            <div class="row">
                <input type="hidden" name="nama_dokumen" value="{{$surat->nama_dokumen}}" >
                <input type="hidden" name="nomor_dokumen" value="{{$surat->nomor_surat}}">
                <input type="hidden" name="surat_id" value="{{$surat->id}}">
                <div class="col-md-6 col-12">
                    <div class="mb-1">
                      <label class="form-label" for="kode">Kode Arsip</label>
                        <input
                            type="text"
                            id="kode"
                            class="form-control"
                            placeholder="Masukkan kode Arsip"
                            name="kode_arsip"
                            required
                        />
                    </div>
                  </div>
            <div class="col-md-6 col-12">
                <div class="mb-1">
                  <!-- <label class="form-label" for="tanggal-column">Tanggal</label> -->
                  <label class="form-label" for="tgl">Tanggal Mulai Arsip</label>
                    <input type="text" 
                    name="tanggal_arsip" 
                    id="tgl"
                    class="form-control flatpickr-basic" 
                    placeholder="Tahun-Bulan-Hari" />
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <label class="form-label" for="masa">Masa Penyimpanan</label>
                  <input
                    type="text"
                    id="masa"
                    class="form-control"
                    name="masa"
                    placeholder="Tulis Disini"
                    required
                  />
                </div>
              </div>
            </div>
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
  <script src="{{ asset(mix('vendors/js/file-uploaders/dropzone.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
@endsection
@section('page-script')
  <!-- Page js files -->
  <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
  <script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>
  <script src="{{ asset(mix('js/scripts/forms/form-file-uploader.js')) }}"></script>
  <script src="{{ asset(mix('js/scripts/extensions/ext-component-toastr.js')) }}"></script>
  <script>
    $(document).ready(function() {

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
    } );
    $('#jquery-val-form').validate({
    rules: {
      nomer:{
        required:true,
      },
      kode:{
        required:true,
      },
      masa:{
        required:true,
      }

    },
    message:{
      nomer:{
        required: "Isi Nomor Dokumen"
      },
      kode:{
        required : 'isi kode dokumen'
      },
      masa:{
        required: 'isi masa dokumen'
      }
    }
  });
  </script>
@endsection
