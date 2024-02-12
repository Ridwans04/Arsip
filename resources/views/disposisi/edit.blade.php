@extends('layouts/contentLayoutMaster')

@section('title', 'Edit Data Disposisi')
@section('vendor-style')
  <!-- vendor css files -->
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/file-uploaders/dropzone.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
  <link href="{{ asset('/template/dist/assets/libs/magnific-popup/magnific-popup.css')}}" rel="stylesheet" type="text/css" />
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
          <h4 class="card-title">Form Lembar Disposisi</h4>
        </div>
        <div class="card-body">
          <form action="/disposisi/{{$disposisi->id}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="row">
              <div class="col-md-6 col-12">
                <div class="mb-1">
                   <label class="form-label" for="nomor-column">Nomor Dokumen</label>
                   <input 
                   type="text" 
                   name="nomor_surat" 
                   id="nomor-column"
                   class="form-control"
                   value="{{$disposisi->nomor_surat}}"
                   >
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <!-- <label class="form-label" for="tanggal-column">Tanggal</label> -->
                  <label class="form-label" for="fp-default">Tanggal</label>
                    <input value="{{$disposisi->tanggal_terima}}" type="text" name="tanggal_terima" id="fp-default" class="form-control flatpickr-basic" placeholder="Tahun-Bulan-Hari" />
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                <label class="form-label" for="select2-multiple">Tujuan</label>
                  <select name="tujuan_id[]" class="select2 form-select" id="select2-multiple" multiple>
                        @foreach($tujuan as $t)
                        {{-- <option value="{{$disposisi->id}}" @if( $disposisi->tujuan == $t->tujuan) selected @endif>{{$t->tujuan}}</option> --}}
                        <option value="{{$t->id}}" >{{$t->tujuan}}</option>
                        @endforeach
                    </select>
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                <label class="form-label" for="select2-basic">Tindak Lanjut</label>
                    <select name="tindak_lanjut" class="select2 form-select" id="select2-basic">
                        <option value="">Pilih Tindakan</option>
                        <option value="Diketahui" @if($disposisi->tindak_lanjut == "Diketahui") selected @endif>Diketahui</option>
                        <option value="Pendapat" @if($disposisi->tindak_lanjut == "Pendapat") selected @endif >Pendapat</option>
                        <option value="Segera Dijawab/Diselesaikan" @if($disposisi->tindak_lanjut == "Segera Dijawab/Diselesaikan") selected @endif >Segera Dijawab/Diselesaikan</option>
                        <option value="Dibicarakan Lebih Lanjut" @if($disposisi->tindak_lanjut == "Dibicarakan Lebih Lanjut") selected @endif >Dibicarakan lebih lanjut</option>
                        <option value="Butuh Penjelasan" @if($disposisi->tindak_lanjut == "Butuh Penjelasan") selected @endif >Butuh Penjelasan</option>
                        <option value="Diteliti/Diperiksa" @if($disposisi->tindak_lanjut == "Diteliti/Diperiksa") selected @endif>Diteliti/Diperiksa</option>
                        <option value="Dilaksanakan" @if($disposisi->tindak_lanjut == "Dilaksanakan") selected @endif>Dilaksanakan</option>
                        <option value="Disimpan" @if($disposisi->tindak_lanjut == "Disimpan") selected @endif>Disimpan</option>
                    </select>
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1 mt-2">
                    <div class="form-floating">
                        <textarea
                        class="form-control"
                        name="keterangan"
                        placeholder="Tulis Keterangan Disini"
                        id="floatingTextarea2"
                        style="height: 100px"
                        >{{$disposisi->keterangan}}</textarea>
                    <label for="floatingTextarea2">Keterangan Tindak Lanjut</label>
                    </div>
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1 mt-2">
                <input
                    type="file"
                    id="dokumen-column"
                    class="form-control"
                    name="dokumen"
                    value="{{$disposisi->dokumen}}"
                   />
                </div>
                  {{-- <a class="image-popup-vertical-fit" href="{{ asset('/disposisi/'.$disposisi->nomor_surat.'/'.$disposisi->dokumen)}}" title="Foto Lembar Disposisi {{$disposisi->nama_dokumen}}"> --}}
                <img class="img-responsive" alt="" src="{{ asset('/disposisi/'.$disposisi->institusi.'/'.$disposisi->nomor_surat.'/'.$disposisi->dokumen)}}"  width="200" style="margin-left:8em"></a>
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
  <script src="{{ asset('/template/dist/assets/libs/magnific-popup/jquery.magnific-popup.min.js')}}"></script>
 <script src="{{ asset('js/bootstrap.min.js') }}"></script> 
@endsection
@section('page-script')
  <!-- Page js files -->
  <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
  <script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>
  <script src="{{ asset(mix('js/scripts/forms/form-file-uploader.js')) }}"></script>
  <script>
   $(document).ready(function () {
        @if(empty($tujuan->id))
         $("#select2-multiple").val(@json($tujuan_id));
         $("#select2-multiple").trigger('change');
        @endif
   });
</script>
@endsection
