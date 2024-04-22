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
    <script src="{{ asset('js/scripts/tool/block-ui.js') }}"></script>
    <script src="{{ asset('js/scripts/tool/sweet-alert.js') }}"></script>
    {{-- <script src="{{ asset('js/scripts/tool/toast.js') }}"></script> --}}
    <script src="https://malsup.github.io/jquery.blockUI.js"></script>
    <script>
        
        const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });
        // MENAMPILKAN MENU PEMILIHAN KLASIFIKASI SURAT
        function klasifikasi_surat() {
            var pilih_klasifikasi = document.getElementById("klasifikasi").value;
            pilih_klasifikasi_surat(pilih_klasifikasi);
        }

        const pilih_klasifikasi_surat = function(pilih_klasifikasi) {
            $('#nama_surat option').not(':first').remove();

            $.ajax({
                method: "get",
                url: "{{ route('pilih_klasifikasi_surat') }}?pilih_klasifikasi=" + pilih_klasifikasi,
                dataType: 'JSON',
                success: function(response) {
                    $('#nama_surat').empty().append($('<option>', {
                        value: "Pilih Nama Surat",
                        text: "Pilih Nama Surat",
                        selected: true,
                        disabled: true
                    }));

                    $.each(response.data, function(i, item) {
                        $('#nama_surat').append($('<option>', {
                            value: `${item.nama_surat}`,
                            text: item.nama_surat
                        }));
                    });
                }
            });
        };

        // MENGAMBIL DATA ARSIP UMUM & PENTING
        function get_data_arsip(institusi) {
            const nama_surat = $('#nama_surat').val();
            $.ajax({
                type: "GET",
                url: `{{ route('get_data_arsip') }}?nama_surat=${nama_surat}&ins=${institusi}`,
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
                                            onclick="modal_detail('${val.id}', '${val.kode_arsip}', '${val.tanggal_arsip}', '${val.masa_penyimpanan}')"
                                            type="button" class="btn btn-icon btn-success w-100 mb-1 text-start">
                                            <i data-feather="edit"></i>
                                            Edit</button>
                                        <a href="arsip/lihat_arsip/${val.id}" target="_blank"
                                            class="btn btn-icon btn-info w-100 mb-1 text-start"><i
                                                data-feather="file-plus"></i>
                                            Lihat</a>
                                    </div>
                                </div>
                            </td>
                            `
                        html_row += `<tr>
                            <td>${val.nomor_surat}</td>
                            <td style="white-space:nowrap">${val.nama_surat}</td>
                            <td>${val.kode_arsip}</td>
                            <td>${val.tanggal_arsip}</td>
                            <td>${menu}</td>
                        </tr>`;
                    });
                    var html_content = `
                <thead>
                    <tr>
                        <th>Nomor Surat</th>
                        <th>Nama Surat</th>
                        <th>Kode Arsip</th>
                        <th>Tanggal</th>
                        <th>Menu</th>
                    </tr>
                </thead>
                <tbody>
                    ${html_row}
                </tbody>`;
                    if ($.fn.DataTable.isDataTable('#arsip')) {
                        $('#arsip').DataTable().destroy();
                    }
                    $('#arsip').unblock().html(html_content).DataTable({
                        searching: false,
                        sorting: false,
                        drawCallback: function() {
                            $('#arsip [data-feather]').each(function() {
                                var icon = $(this).data('feather');
                                $(this).empty().append(feather.icons[icon].toSvg({
                                    width: 14,
                                    height: 14
                                }));
                            });
                        }
                    });
                },
                error: function(error) {
                    Swal.fire(
                        'Kesalahan Data',
                        '',
                        'error'
                    )
                }
            });
        }

        // CARI DATA ARSIP UMUM
        function cari_data(name, institusi) {
            var value = $('#' + name).val();
            if (value != '') {
                $.ajax({
                    type: "GET",
                    url: `{{ route('cari_data_umum') }}?name=${name}&value=${value}&institusi=${institusi}`,
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
                                            class="btn btn-icon btn-info w-100 mb-1 text-start"><i
                                                data-feather="file-plus"></i>
                                            Lihat</a>
                                    </div>
                                </div>
                            </td>
                            `
                            html_row += `<tr>
                            <td>${val.nomor_surat}</td>
                            <td style="white-space:nowrap">${val.nama_surat}</td>
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
                        if ($.fn.DataTable.isDataTable('#arsip')) {
                            $('#arsip').DataTable().destroy();
                        }
                        $('#arsip').unblock().html(html_content).DataTable({
                            searching: false,
                            sorting: false,
                            drawCallback: function() {
                                $('#arsip [data-feather]').each(function() {
                                    var icon = $(this).data('feather');
                                    $(this).empty().append(feather.icons[icon].toSvg({
                                        width: 14,
                                        height: 14
                                    }));
                                });
                            }
                        });
                        $('#'.name).val();
                    },
                    error: function(error) {
                        Swal.fire(
                            'Error',
                            'Data Tidak Ditemukan',
                            'error'
                        )
                    }
                });
            } else {
                get_arsip_umum(institusi);
            }
        }

        // CARI DATA ARSIP PENTING
        function cari_data_penting(institusi) {
            var value = $('#cari_data_penting').val();
            if (value != '') {
                $.ajax({
                    type: "GET",
                    url: `{{ route('cari_data_penting') }}?name=${name}&value=${value}&institusi=${institusi}`,
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
                        if ($.fn.DataTable.isDataTable('#arsip')) {
                            $('#arsip_penting').DataTable().destroy();
                        }
                        $('#arsip_penting').unblock().html(html_content).DataTable({
                            searching: false,
                            sorting: false,
                            drawCallback: function() {
                                $('#arsip [data-feather]').each(function() {
                                    var icon = $(this).data('feather');
                                    $(this).empty().append(feather.icons[icon].toSvg({
                                        width: 14,
                                        height: 14
                                    }));
                                });
                            }
                        });
                    },
                    error: function(error) {
                        Swal.fire(
                            'Error',
                            'Data Tidak Ditemukan',
                            'error'
                        )
                    }
                });
            } else {
                get_arsip_penting(institusi);
            }
        }

        // MODAL DATA
        function modal_detail(id, kode, tgl, masa) {
            $('#id_arsip').val(id);
            $('#kode_arsip').val(kode);
            $('#tgl_arsip').val(tgl);
            $('#masa_arsip').val(masa);
            $('#modal_detail').modal('show');
        }

        function update_data(obj) {
            const form = new FormData(obj);
            Swal.fire({
                icon: 'question',
                title: `Apa anda yakin ingin memperbarui data ?`,
                showCancelButton: true,
                cancelButtonText: "Tidak",
                confirmButtonText: 'Ya',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "put",
                        url: `{{ route('update_arsip') }}`,
                        data: {
                            id: form.get('id_arsip'),
                            kode: form.get('kode_arsip'),
                            tanggal: form.get('tgl_arsip'),
                            masa: form.get('masa_arsip'),
                        },
                        beforeSend: function() {
                            Swal.fire({
                                html: '<div style="height:50px"><div class="spinner-border text-danger" role="status"></div></div>',
                                showConfirmButton: false,
                                allowOutsideClick: false,
                                background: 'transparent',
                            });
                        },
                        dataType: 'JSON',
                        success: function(response) {
                            if (response.success) {
                                Toast.fire({
                                    icon: 'success',
                                    title: "Data berhasil diperbarui"
                                });
                                $('#modal_detail').modal('hide');
                            } else {
                                Toast.fire({
                                    icon: "error",
                                    title: "Data gagal diperbarui"
                                });
                                $('#modal_detail').modal('hide');
                            }
                        },
                        error: function(response) {
                            Swal.fire('Error', '', 'error')
                        }
                    })
                }
            })
        }
    </script>
@endsection
