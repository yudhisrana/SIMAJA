<?= $this->extend('layouts/default') ?>

<?= $this->section('style'); ?>
<!-- DataTables -->
<link
    rel="stylesheet"
    href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css" />
<link
    rel="stylesheet"
    href="/plugins/datatables-responsive/css/responsive.bootstrap4.min.css" />

<!-- SweetAlert2 -->
<link
    rel="stylesheet"
    href="/plugins/sweetalert2/sweetalert2.min.css" />
<?= $this->endSection('style'); ?>

<?= $this->section('content') ?>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- table -->
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title">Data <?= $page_name ?></h3>
                            <button class="btn btn-primary btnTambahProdi">
                                <i class="fas fa-plus mr-1"></i>
                                <span>Tambah Data</span>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table
                            id="dataProdi"
                            class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Program Studi</th>
                                    <th>Tanggal Dibuat</th>
                                    <th>Tanggal Diupdate</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($prodi as $key => $value) { ?>
                                    <tr>
                                        <td><?= $key + 1; ?></td>
                                        <td><?= esc(trim($value['prodi_name'] ?? '')) ?></td>
                                        <td>
                                            <?= $value['created_at'] ? date('d-m-Y H:i:s', strtotime($value['created_at'])) : '-' ?>
                                        </td>
                                        <td>
                                            <?= $value['updated_at'] ? date('d-m-Y H:i:s', strtotime($value['updated_at'])) : '-' ?>
                                        </td>
                                        <td>
                                            <button class="btn btn-warning btnEditProdi"
                                                data-id="<?= $value['id']; ?>"
                                                data-prodi="<?= htmlspecialchars(trim($value['prodi_name']), ENT_QUOTES) ?>">
                                                <i class="far fa-edit"></i>
                                            </button>
                                            <button class="btn btn-danger btnDeleteProdi"
                                                data-id="<?= $value['id']; ?>">
                                                <i class="far fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="modalProdi" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalProdiLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalProdiLabel">-</h5>
            </div>
            <div class="modal-body">
                <!-- form -->
                <form id="formProdi">
                    <?= csrf_field(); ?>
                    <div class="form-group">
                        <label for="prodi">Program Studi</label>
                        <input type="text" name="prodi" class="form-control" id="prodi" placeholder="Informatika" aria-describedby="prodi-error">
                        <span id="prodi-error" class="error invalid-feedback" style="display: none;"></span>
                    </div>
                    <div class="d-flex justify-content-end align-items-center">
                        <button id="cancelModal" type="button" class="btn btn-danger mr-2" data-dismiss="modal">Batal</button>
                        <button id="btnSubmitProdi" type="submit" class="btn btn-primary">-</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection('content') ?>

<?= $this->section('script'); ?>
<!-- DataTables -->
<!-- DataTables  & Plugins -->
<script src="/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- SweetAlert2 -->
<script src="/plugins/sweetalert2/sweetalert2.min.js"></script>
<script>
    // csrf token
    let csrfToken = '<?= csrf_token(); ?>';
    let csrfHash = '<?= csrf_hash(); ?>';

    // datatable
    $(function() {
        $("#dataProdi")
            .DataTable({
                responsive: true,
                lengthChange: false,
                autoWidth: false,
                pageLength: 5,
                columnDefs: [{
                        targets: 0,
                        searchable: false,
                        width: '25px'
                    },
                    {
                        targets: 1,
                        searchable: true,
                    },
                    {
                        targets: 2,
                        searchable: false,
                    },
                    {
                        targets: 3,
                        searchable: false,
                    },
                    {
                        targets: 4,
                        orderable: false,
                        className: 'text-center'
                    }
                ]
            })
    });

    $(function() {
        // function reset
        function reset() {
            $('#formProdi')[0].reset();
            $('#prodi').removeClass('is-invalid');
            $('#prodi-error').text('').hide();
        }

        // modal tambah
        $('.btnTambahProdi').click(function() {
            modeModal = 'tambah';
            url = 'program-studi/create-data';
            method = 'POST';

            $('#modalProdiLabel').text('Tambah Data');
            $('#btnSubmitProdi').text('Simpan');
            $('#modalProdi').modal('show');
        });

        // modal edit
        $('.btnEditProdi').click(function() {
            const id = $(this).data('id')
            const prodi = $(this).data('prodi')
            modeModal = 'edit';
            url = 'program-studi/update-data/' + id;
            method = 'POST';

            $('#modalProdiLabel').text('Edit Data');
            $('#btnSubmitProdi').text('Update');
            $('#prodi').val(prodi);
            $('#modalProdi').modal('show');
        });

        // tambah dan update
        $('#formProdi').submit(function(e) {
            e.preventDefault();
            const prodi = $('#prodi').val();

            $.ajax({
                url: url,
                method: method,
                data: {
                    [csrfToken]: csrfHash,
                    prodi: prodi,
                },
                success: function(res) {
                    if (res.success) {
                        Swal.fire({
                            title: "Sukses",
                            text: res.message,
                            icon: "success"
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        if (res.errors && res.errors.prodi) {
                            $('#prodi').addClass('is-invalid');
                            $('#prodi-error').text(res.errors.prodi).show();
                        }
                    }
                },
                error: function() {
                    Swal.fire({
                        title: 'Opsss..',
                        text: 'Terjadi kesalahan server, silahkan coba lagi!',
                        icon: "error"
                    })
                }
            })
        });

        // modal delete
        $('.btnDeleteProdi').click(function() {
            const id = $(this).data('id')
            url = baseUrl + 'program-studi/delete-data/' + id;
            method = 'POST';

            Swal.fire({
                title: "Yakin hapus data?",
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#C82333",
                confirmButtonText: "Ya, hapus!",
                cancelButtonColor: "#5A6268",
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        method: method,
                        data: {
                            [csrfToken]: csrfHash,
                        },
                        success: function(res) {
                            if (res.success) {
                                Swal.fire({
                                    title: "Dihapus",
                                    text: res.message,
                                    icon: "success"
                                }).then(() => {
                                    location.reload();
                                })
                            } else {
                                Swal.fire({
                                    title: 'Opsss..',
                                    text: 'Gagal menghapus data tahunajaran',
                                    icon: "error"
                                })
                            }
                        },
                        error: function() {
                            Swal.fire({
                                title: 'Opsss..',
                                text: 'Terjadi kesalahan server, silahkan coba lagi!',
                                icon: "error"
                            })
                        }
                    })
                }
            });
        });

        // focus input saat modal selesai ditampilkan
        $('#modalProdi').on('shown.bs.modal', function() {
            if (modeModal === 'tambah') {
                $('#prodi').trigger('focus');
            }
        });

        // reset batal
        $('#cancelModal').click(function() {
            document.activeElement.blur();
            reset();
        });
    });
</script>
<?= $this->endSection('script'); ?>