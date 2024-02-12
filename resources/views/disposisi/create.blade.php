@extends('layouts/contentLayoutMaster')

@section('title', 'Input Data Disposisi')

@section('vendor-style')
  <!-- vendor css files -->
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/file-uploaders/dropzone.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
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
          <h4 class="card-title">Form Lembar Disposisi</h4>
        </div>
        <div class="card-body">
          <form id="jquery-val-form" action="/disposisi/store" method="POST" onsubmit="onSubmit" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="col-md-6 col-12">
                <div class="mb-1">
                   <label class="form-label" for="nomor">Nomor Surat</label>
                    <select name="surat_id" class="select2 form-select" id="nomor" required>
                        <option value="">Pilih Dokumen</option>
                        @foreach($suratmasuk as $s)
                        <option value="{{$s->id}}">{{$s->nomor_surat}}</option>
                        @endforeach
                    </select>
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <!-- <label class="form-label" for="tanggal-column">Tanggal</label> -->
                  <label class="form-label" for="date">Tanggal Terima</label>
                    <input type="text" 
                    name="tanggal_terima" 
                    id="date" 
                    class="form-control flatpickr-basic" 
                    placeholder="Tahun-Bulan-Hari" 
                    required/>
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                <label class="form-label" for="tujuan">Tujuan</label>
                  <select name="tujuan_id[]" class="select2 form-select" id="tujuan" multiple required>Pilih Tujuan
                        @foreach($tujuan as $s)
                        <option value="{{$s->id}}">{{$s->tujuan}}</option>
                        @endforeach
                    </select>
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                <label class="form-label" for="select2-basic">Tindak Lanjut</label>
                    <select name="tindak_lanjut" class="select2 form-select" id="select2-basic" required>
                        <option value="">Pilih Tindakan</option>
                        <option value="Diketahui">Diketahui</option>
                        <option value="Pendapat">Pendapat</option>
                        <option value="Segera Dijawab/Diselesaikan">Segera Dijawab/Diselesaikan</option>
                        <option value="Dibicarakan Lebih Lanjut">Dibicarakan lebih lanjut</option>
                        <option value="Butuh Penjelasan">Butuh Penjelasan</option>
                        <option value="Diteliti/Diperiksa">Diteliti/Diperiksa</option>
                        <option value="Dilaksanakan">Dilaksanakan</option>
                        <option value="Disimpan">Disimpan</option>
                    </select>
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <label for="catatan_column" class="form-label">Catatan</label>
                  <input type="text"
                  name="catatan"
                  id="catatan_column"
                  class="form-control"
                  placeholder="Tulis Disini">
                </div>
              </div>
              <!-- UPLOAD FILE -->
              <div class="col-md-6 col-12">
                <div class="mb-1" style="margin-top: 0.1rem">
                  <label for="doc" class="form-label">Upload Disposisi</label>
                <input
                    type="file"
                    id="doc"
                    class="form-control"
                    name="dokumen"
                    required
                  />
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1 mt-1">
                    <div class="form-floating">
                        <textarea
                        class="form-control"
                        name="keterangan"
                        placeholder="Tulis Keterangan Disini"
                        id="ket"
                        style="height: 100px"
                        ></textarea>
                    <label for="ket">Keterangan Tindak Lanjut</label>
                    </div>
                </div>
              </div>
              <div class="col-md-6 col-12" style="margin-top: -0.7em;">
                <div class="alert alert-success" role="alert">
                  <div class="alert-body"><strong>NB :</strong> upload dokumen hanya dalam bentuk jpeg, jpg, dan png</div>
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
   $(document).ready(function () {
         $(".select2").select2();

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
        
   });

   $('#jquery-val-form').validate({
    rules: {
      nomor:{
        required:true,
      },
      tujuan:{
        required:true,
      },
      tindakLanjut:{
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
      tujuan:{
        required: 'Pilih tujuan'
      },
      tindakLanjut:{
        required: 'Pilih tindak lanjut yang diberikan'
      },
      doc:{
        required: 'Ipload dokumen disposisi'
      }
    }
  });
</script>

@endsection
