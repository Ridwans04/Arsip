@section('vendor-style')
    {{-- vendor css files TABLE --}}
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
@endsection

@section('page-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
@endsection

@section('vendor-script')
    {{-- vendor files TABLE --}}
    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/jszip.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/pdfmake.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/vfs_fonts.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
    <!-- vendor files INPUT-->
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
@endsection

@section('page-script')
    <!-- Page js files -->
    <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/extensions/ext-component-sweet-alerts.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/extensions/ext-component-toastr.js')) }}"></script>
    <script>
        $(document).ready(function() {

            @if ($message = Session::get('success'))
                toastr['success'](
                    '{!! $message !!}',
                    'Sukses', {
                        showDuration: 500
                    }
                );
            @endif

        });

        function get_arsip_umum(institusi) {
            const klasifikasi = $('#jenis_surat').val();
            $.ajax({
                type: "GET",
                url: `{{ route('get_arsip_umum') }}?klasifikasi=${klasifikasi}&ins=${institusi}`,
                beforeSend: function() {
                    $('#arsip').block({
                        message: '<div class="loader-box"><div class="loader-1"></div></div>',
                        css: {
                            backgroundColor: 'transparent',
                            border: '0'
                        },
                        overlayCSS: {
                            backgroundColor: '#fff',
                            opacity: 0.8
                        }
                    });
                },
                dataType: "JSON",
                success: function(response) {
                    var html_row = "";
                    var menu = "";
                    var date = new Date();
                    $.each(response.data, function(key, val) {
                        menu =
                            `<div class="btn-group">
                                    <button class="btn btn-success dropdown-toggle" type="button"
                                        id="dropdownMenuButton2" data-bs-toggle="dropdown"
                                        aria-expanded="false"><i data-feather="list"></i>
                                    </button>
                                    <div class="dropdown-menu p-1" aria-labelledby="dropdownMenuButton2">
                                        <button
                                            onclick="window.location.href='/surat/${val.id}/edit'"
                                            type="button" class="btn btn-icon btn-success w-100 mb-1 text-start">
                                            <i data-feather="edit"></i>
                                            Edit</button>
                                        <a href="arsip/lihat_arsip/${val.id}" target="_blank"
                                            class="btn btn-icon btn-success w-100 mb-1 text-start"><i
                                                data-feather="file-plus"></i>
                                            Lihat</a>
                                        <form id="hapus_${val.id}"
                                            action="/surat/${val.id}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button type="button"
                                                class="btn btn-icon btn-danger w-100 mb-1 text-start"
                                                onclick="notif_delete(${val.id})" value="delete">
                                                <i data-feather="trash"></i> Hapus
                                            </button>
                                        </form>
                                        <a href="../ekspedisi/${val.id}/suratEkspedisi"
                                            target="_blank" class="btn btn-icon btn-info w-100 mb-1"><i
                                            data-feather="book-open"></i>
                                            Ekspedisi</a>
                                        <a href="../arsip/${val.id}/suratArsip"
                                            target="_blank"
                                            class="btn btn-icon btn-info w-100 text-start"><i
                                            data-feather="folder-plus"></i> Catatan
                                        </a>
                                    </div>
                                </div>
                            </td>
                            `
                        html_row += `<tr>
                            <td>${val.nomor_surat}</td>
                            <td style="white-space:nowrap">${val.nama_dokumen}</td>
                            <td>${val.tanggal}</td>
                            <td>${val.dari}</td>
                            <td>${val.tujuan_surat}</td>
                            <td>${menu}</td>
                        </tr>`;
                    });
                    var html_content = `
                <thead>
                    <tr>
                        <th>Nomor Surat</th>
                        <th>Nama Surat</th>
                        <th>Tanggal</th>
                        <th>Dari</th>
                        <th>Tujuan</th>
                        <th>Menu</th>
                    </tr>
                </thead>
                <tbody>
                    ${html_row}
                </tbody>`;
                    $('#arsip').html(html_content);
                    if ($.fn.DataTable.isDataTable('#arsip')) {
                        $('#arsip').DataTable().destroy();
                    }
                    $('#arsip').DataTable({
                        searching: false,
                        sorting: false,
                    });
                    $('#arsip').unblock();
                    feather.replace({
                        width: 14,
                        height: 14
                    });
                },
                error: function(error) {
                    var html_content = `
                    <thead>
                        <tr>
                            <th>Nomor Surat</th>
                            <th>Nama Surat</th>
                            <th>Tanggal</th>
                            <th>Dari</th>
                            <th>Tujuan</th>
                            <th>Menu</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>`;
                    $('#arsip').html(html_content);
                    $('#arsip').DataTable();
                    $('#arsip').unblock();
                    Swal.fire(
                        'Error',
                        '',
                        'error'
                    )
                }
            });
        }

        function get_arsip_penting(institusi) {
            $.ajax({
                type: "GET",
                url: `{{ route('get_arsip_penting') }}?ins=${institusi}`,
                beforeSend: function() {
                    $('#arsip_penting').block({
                        message: '<div class="loader-box"><div class="loader-1"></div></div>',
                        css: {
                            backgroundColor: 'transparent',
                            border: '0'
                        },
                        overlayCSS: {
                            backgroundColor: '#fff',
                            opacity: 0.8
                        }
                    });
                },
                dataType: "JSON",
                success: function(response) {
                    var html_row = "";
                    var menu = "";
                    var date = new Date();
                    $.each(response.data, function(key, val) {
                        menu =
                            `<div class="btn-group">
                                    <button class="btn btn-success dropdown-toggle" type="button"
                                        id="dropdownMenuButton2" data-bs-toggle="dropdown"
                                        aria-expanded="false"><i data-feather="list"></i>
                                    </button>
                                    <div class="dropdown-menu p-1" aria-labelledby="dropdownMenuButton2">
                                        <button
                                            onclick="window.location.href='/surat/${val.id}/edit'"
                                            type="button" class="btn btn-icon btn-success w-100 mb-1 text-start">
                                            <i data-feather="edit"></i>
                                            Edit</button>
                                        <a href="arsip/lihat_arsip/${val.id}" target="_blank"
                                            class="btn btn-icon btn-success w-100 mb-1 text-start"><i
                                                data-feather="file-plus"></i>
                                            Lihat</a>
                                        <form id="hapus_${val.id}"
                                            action="/surat/${val.id}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button type="button"
                                                class="btn btn-icon btn-danger w-100 mb-1 text-start"
                                                onclick="notif_delete(${val.id})" value="delete">
                                                <i data-feather="trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                            `
                        html_row += `<tr>
                            <td>${val.nomor_surat}</td>
                            <td style="white-space:nowrap">${val.nama_dokumen}</td>
                            <td>${val.tanggal}</td>
                            <td>${val.dari}</td>
                            <td>${val.tujuan_surat}</td>
                            <td>${menu}</td>
                        </tr>`;
                    });
                    var html_content = `
                <thead>
                    <tr>
                        <th>Nomor Surat</th>
                        <th>Nama Surat</th>
                        <th>Tanggal</th>
                        <th>Dari</th>
                        <th>Tujuan</th>
                        <th>Menu</th>
                    </tr>
                </thead>
                <tbody>
                    ${html_row}
                </tbody>`;
                    $('#arsip_penting').html(html_content);
                    if ($.fn.DataTable.isDataTable('#arsip_penting')) {
                        $('#arsip_penting').DataTable().destroy();
                    }
                    $('#arsip_penting').DataTable({
                        searching: false,
                        sorting: false,
                    });
                    $('#arsip_penting').unblock();
                    feather.replace({
                        width: 14,
                        height: 14
                    });
                },
                error: function(error) {
                    var html_content = `
                    <thead>
                        <tr>
                            <th>Nomor Surat</th>
                            <th>Nama Surat</th>
                            <th>Tanggal</th>
                            <th>Dari</th>
                            <th>Tujuan</th>
                            <th>Menu</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>`;
                    $('#arsip_penting').html(html_content);
                    $('#arsip_penting').DataTable();
                    $('#arsip_penting').unblock();
                    Swal.fire(
                        'Error',
                        '',
                        'error'
                    )
                }
            });
        }

        function cari_data(name, institusi) {
            var value = $('#'+ name).val();
            console.log(value);
            if(value != ''){
                $.ajax({
                type: "GET",
                url: `{{ route('cari_data') }}?name=${name}&value=${value}&institusi=${institusi}`,
                beforeSend: function() {
                    $('#arsip').block({
                        message: '<div class="loader-box"><div class="loader-1"></div></div>',
                        css: {
                            backgroundColor: 'transparent',
                            border: '0'
                        },
                        overlayCSS: {
                            backgroundColor: '#fff',
                            opacity: 0.8
                        }
                    });
                },
                dataType: "JSON",
                success: function(response) {
                    var html_row = "";
                    var menu = "";
                    var date = new Date();
                    $.each(response.data, function(key, val) {
                        menu =
                            `<div class="btn-group">
                                    <button class="btn btn-success dropdown-toggle" type="button"
                                        id="dropdownMenuButton2" data-bs-toggle="dropdown"
                                        aria-expanded="false"><i data-feather="list"></i>
                                    </button>
                                    <div class="dropdown-menu p-1" aria-labelledby="dropdownMenuButton2">
                                        <button
                                            onclick="window.location.href='/surat/${val.id}/edit'"
                                            type="button" class="btn btn-icon btn-success w-100 mb-1 text-start">
                                            <i data-feather="edit"></i>
                                            Edit</button>
                                        <a href="arsip/lihat_arsip/${val.id}" target="_blank"
                                            class="btn btn-icon btn-success w-100 mb-1 text-start"><i
                                                data-feather="file-plus"></i>
                                            Lihat</a>
                                        <form id="hapus_${val.id}"
                                            action="/surat/${val.id}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button type="button"
                                                class="btn btn-icon btn-danger w-100 mb-1 text-start"
                                                onclick="notif_delete(${val.id})" value="delete">
                                                <i data-feather="trash"></i> Hapus
                                            </button>
                                        </form>
                                        <a href="../ekspedisi/${val.id}/suratEkspedisi"
                                            target="_blank" class="btn btn-icon btn-info w-100 mb-1"><i
                                            data-feather="book-open"></i>
                                            Ekspedisi</a>
                                        <a href="../arsip/${val.id}/suratArsip"
                                            target="_blank"
                                            class="btn btn-icon btn-info w-100 text-start"><i
                                            data-feather="folder-plus"></i> Catatan
                                        </a>
                                    </div>
                                </div>
                            </td>
                            `
                        html_row += `<tr>
                            <td>${val.nomor_surat}</td>
                            <td style="white-space:nowrap">${val.nama_dokumen}</td>
                            <td>${val.tanggal}</td>
                            <td>${val.dari}</td>
                            <td>${val.tujuan_surat}</td>
                            <td>${menu}</td>
                        </tr>`;
                    });
                    var html_content = `
                <thead>
                    <tr>
                        <th>Nomor Surat</th>
                        <th>Nama Surat</th>
                        <th>Tanggal</th>
                        <th>Dari</th>
                        <th>Tujuan</th>
                        <th>Menu</th>
                    </tr>
                </thead>
                <tbody>
                    ${html_row}
                </tbody>`;
                    $('#arsip').html(html_content);
                    if ($.fn.DataTable.isDataTable('#arsip')) {
                        $('#arsip').DataTable().destroy();
                    }
                    $('#arsip').DataTable({
                        searching: false,
                        sorting: false,
                    });
                    $('#arsip').unblock();
                    feather.replace({
                        width: 14,
                        height: 14
                    });
                    $('#'.name).val();
                },
                error: function(error) {
                    var html_content = `
                    <thead>
                        <tr>
                            <th>Nomor Surat</th>
                            <th>Nama Surat</th>
                            <th>Tanggal</th>
                            <th>Dari</th>
                            <th>Tujuan</th>
                            <th>Menu</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>`;
                    $('#arsip').html(html_content);
                    $('#arsip').DataTable();
                    $('#arsip').unblock();
                    Swal.fire(
                        'Error',
                        '',
                        'error'
                    )
                }
            });
            }
        }

        function notif_delete(id) {
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
                    $('#hapus_' + id).submit();
                }
            });
        }
    </script>
@endsection
