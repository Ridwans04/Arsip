@extends('layouts/contentLayoutMaster')

@section('title', 'Buat Surat Baru')

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
          <h4 class="card-title">Form Buat Surat </h4>
        </div>
        <div class="card-body">
          <form action="/surat/shop" id="jquery-val-form" method="POST">
            @csrf
            <div class="row">
              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <label class="form-label" for="nm">Nama Surat</label>
                  <input
                    type="text"
                    id="nm"
                    class="form-control"
                    name="nama_dokumen"
                    placeholder="Tulis Disini"
                  />
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <label class="form-label" for="klasifikasi">Klasifikasi</label>
                    <select class="form-select select2" name="klasifikasi" id="klasifikasi">
                        <option value="">Pilih Klasifikasi</option>
                        <option value="UmumMasuk">Umum Masuk</option>
                        <option value="UmumKeluar">Umum Keluar</option>
                        <option value="Penting">Penting</option>
                    </select>
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
      
        $(".basic-select2").select2();
        $("#jenis_eks").select2();

        @if ($message = Session::get('success'))

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
      nm:{
        required:true,
      },
      klasifikasi:{
        required:true,
      }

    },
    message:{
      nm:{
        required: "Isi Nomor Dokumen"
      },
      klasifikasi:{
        required : 'isi kode dokumen'
      }
    }
  });

  </script>
@endsection
