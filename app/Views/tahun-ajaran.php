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
                            <button class="btn btn-primary btnTambahTahunAjaran">
                                <i class="fas fa-plus mr-1"></i>
                                <span>Tambah Data</span>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table
                            id="dataTahunAjaran"
                            class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tahun Ajaran</th>
                                    <th>Tanggal Dibuat</th>
                                    <th>Tanggal Diupdate</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($tahun_ajaran as $key => $value) { ?>
                                    <tr>
                                        <td><?= $key + 1; ?></td>
                                        <td><?= esc(trim($value['tahun'] ?? '')) ?></td>
                                        <td>
                                            <?= $value['created_at'] ? date('d-m-Y H:i:s', strtotime($value['created_at'])) : '-' ?>
                                        </td>
                                        <td>
                                            <?= $value['updated_at'] ? date('d-m-Y H:i:s', strtotime($value['updated_at'])) : '-' ?>
                                        </td>
                                        <td>
                                            <button class="btn btn-warning btnEditTahunAjaran"
                                                data-id="<?= $value['id']; ?>"
                                                data-tahun_ajaran="<?= htmlspecialchars(trim($value['tahun']), ENT_QUOTES) ?>">
                                                <i class="far fa-edit"></i>
                                            </button>
                                            <button class="btn btn-danger btnDeleteTahunAjaran"
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
<div class="modal fade" id="modalTahunAjaran" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalTahunAjaranLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTahunAjaranLabel">-</h5>
            </div>
            <div class="modal-body">
                <!-- form -->
                <form id="formTahunAjaran">
                    <?= csrf_field(); ?>
                    <div class="form-group">
                        <label for="tahun_ajaran">Tahun Ajaran</label>
                        <input type="text" name="tahun_ajaran" class="form-control" id="tahun_ajaran" placeholder="2025/2026" aria-describedby="tahun_ajaran-error">
                        <span id="tahun_ajaran-error" class="error invalid-feedback" style="display: none;"></span>
                    </div>
                    <div class="d-flex justify-content-end align-items-center">
                        <button id="cancelModal" type="button" class="btn btn-danger mr-2" data-dismiss="modal">Batal</button>
                        <button id="btnSubmitTahunAjaran" type="submit" class="btn btn-primary">-</button>
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
        $("#dataTahunAjaran")
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
            $('#formTahunAjaran')[0].reset();
            $('#tahun_ajaran').removeClass('is-invalid');
            $('#tahun_ajaran-error').text('').hide();
        }

        // modal tambah
        $('.btnTambahTahunAjaran').click(function() {
            modeModal = 'tambah';
            url = 'tahun-ajaran/create-data';
            method = 'POST';

            $('#modalTahunAjaranLabel').text('Tambah Data');
            $('#btnSubmitTahunAjaran').text('Simpan');
            $('#modalTahunAjaran').modal('show');
        });

        // modal edit
        $('.btnEditTahunAjaran').click(function() {
            const id = $(this).data('id')
            const tahunAjaran = $(this).data('tahun_ajaran')
            modeModal = 'edit';
            url = 'tahun-ajaran/update-data/' + id;
            method = 'POST';

            $('#modalTahunAjaranLabel').text('Edit Data');
            $('#btnSubmitTahunAjaran').text('Update');
            $('#tahun_ajaran').val(tahunAjaran)
            $('#modalTahunAjaran').modal('show');
        });

        // tambah dan update
        $('#formTahunAjaran').submit(function(e) {
            e.preventDefault();
            const tahunAjaran = $('#tahun_ajaran').val();

            $.ajax({
                url: url,
                method: method,
                data: {
                    [csrfToken]: csrfHash,
                    tahun_ajaran: tahunAjaran,
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
                        if (res.errors && res.errors.tahun_ajaran) {
                            $('#tahun_ajaran').addClass('is-invalid');
                            $('#tahun_ajaran-error').text(res.errors.tahun_ajaran).show();
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
        $('.btnDeleteTahunAjaran').click(function() {
            const id = $(this).data('id')
            url = baseUrl + 'tahun-ajaran/delete-data/' + id;
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
        $('#modalTahunAjaran').on('shown.bs.modal', function() {
            if (modeModal === 'tambah') {
                $('#tahun_ajaran').trigger('focus');
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