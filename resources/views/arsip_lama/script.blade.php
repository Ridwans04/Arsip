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
@endsection

@section('page-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
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
    <script src="https://malsup.github.io/jquery.blockUI.js"></script>
    <script>
        // MENAMPILKAN MENU PEMILIHAN KLASIFIKASI SURAT
        function klasifikasi_surat() {
            var pilih_klasifikasi = document.getElementById("klasifikasi").value;
            pilih_klasifikasi_surat(pilih_klasifikasi);
        }

        // MENAMPILKAN PILIHAN SURAT BERDASARKAN KLASIFIKASI
        const pilih_klasifikasi_surat = function(pilih_klasifikasi) {
            $('#nama_surat option').not(':first').remove();

            $.ajax({
                method: "get",
                url: "{{ route('pilih_klasifikasi_surat') }}?pilih_klasifikasi=" + pilih_klasifikasi,
                dataType: 'JSON',
                success: function(response) {
                    $('#nama_surat').empty().append($('<option>', {
                        value: "",
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

        // MENGAMBIL DATA ARSIP UMUM
        function get_arsip_lama(institusi) {
            const nama_surat = $('#nama_surat').val();
            $.ajax({
                type: "GET",
                url: `{{ route('get_arsip_lama') }}?nama_surat=${nama_surat}&ins=${institusi}`,
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
                    var tableContent = generateTableContent(response.data);
                    initializeDataTable(tableContent);
                    $('#arsip').unblock();
                },
                error: function(error) {
                    showErrorMessage('Pilih Surat Dahulu');
                    $('#' + name).val('');
                }
            });
        }

        // MEMBUAT PESAN ERROR
        function ErrorMsg(message) {
            Swal.fire('Error', message, 'error');
        }

        function initializeDataTable(content) {
            if ($.fn.DataTable.isDataTable('#arsip')) {
                $('#arsip').DataTable().destroy();
            }

            $('#arsip').html(content).DataTable({
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
        }

        // FUNGSI MENGAMBIL TABEL DAN DATA ARSIP
        function generateTableContent(data) {
            var htmlRow = "";

            $.each(data, function(key, val) {
                menu =
                    `<div class="btn-group">
                        <button class="btn btn-success dropdown-toggle" type="button"
                            id="dropdownMenuButton2" data-bs-toggle="dropdown"
                            aria-expanded="false"><i data-feather="list"></i>
                        </button>
                        <div class="dropdown-menu p-1" aria-labelledby="dropdownMenuButton2">
                            <a href="lihat_arsip/${val.id}" target="_blank"
                                class="btn btn-icon btn-info w-100 mb-1 text-start"><i
                                    data-feather="file-plus"></i>
                                Lihat</a>
                            <button
                                onclick="detail_arsip('${val.id}','${val.arsip_id}', '${val.kode_arsip}', '${val.tanggal_arsip}', '${val.masa}')"
                                type="button" class="btn btn-icon btn-success w-100 mb-1 text-start">
                                <i data-feather="edit"></i>
                                Edit</button>
                            <button class="btn btn-icon btn-secondary w-100 mb-1 text-start" onclick="detail_ekspedisi('${val.id}', '${val.tanggal_kirim}', '${val.nama_penerima}')">
                                <i data-feather="message-square"></i>
                                Ekspedisi</button>
                            <form id="hapus_data_${val.id}"
                                action="hapus_data/${val.id}" method="POST">
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
                htmlRow += `<tr>
                            <td>${val.nomor_surat}</td>
                            <td style="white-space:nowrap">${val.nama_surat}</td>
                            <td>${val.tanggal}</td>
                            <td>${val.tujuan_surat}</td>
                            <td>${menu}</td>
                        </tr>`;
            });
            return `
            <thead>
                <tr>
                    <th>Nomor Surat</th>
                    <th>Nama Surat</th>
                    <th>Tanggal</th>
                    <th>Tujuan Surat</th>
                    <th>Menu</th>
                </tr>
            </thead>
            <tbody>
                ${htmlRow}
            </tbody>`;
        }

        // CARI DATA ARSIP
        function cari_data(name, institusi) {
            var value = $('#' + name).val();
            var nama_surat = $('#nama_surat').val();
            var arsip = 'arsip_lama';

            if (!nama_surat) {
                ErrorMsg('Pilih Surat Dahulu');
                $('#' + name).val('');
                return;
            }
            if (value === '') {
                return;
            }

            $.ajax({
                type: "GET",
                url: `{{ route('cari_data_umum') }}?name=${name}&value=${value}&institusi=${institusi}&arsip=${arsip}&nama_surat=${nama_surat}`,
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
                    var tableContent = generateTableContent(response.data);
                    initializeDataTable(tableContent);
                    $('#arsip').unblock();
                },
                error: function(error) {
                    showErrorMessage('Pilih Surat Dahulu');
                    $('#' + name).val('');
                }
            });
        }

        // MODAL CATATAN ARSIP
        function detail_arsip(surat_id, arsip_id, kode, tgl, masa) {
            $('#id_surat').val(surat_id);
            $('#id_arsip').val(arsip_id);
            $('#kode_arsip').val(kode);
            $('#tgl_arsip').val(tgl);
            $('#masa_arsip').val(masa);
            $('#catatan_arsip').modal('show');
        }

        function detail_ekspedisi(id, tgl, nama) {
            $('#id_ekspedisi').val(id);
            $('#tgl_ekspedisi').val(tgl);
            $('#nama_penerima').val(nama);
            $('#catatan_ekspedisi').modal('show');
        }

        // MENGHAPUS DATA ARSIP
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
                    $('#hapus_data_' + id).submit();
                }
            });
        }
    </script>
@endsection
