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
                            <button class="btn btn-primary btnTambahKelas">
                                <i class="fas fa-plus mr-1"></i>
                                <span>Tambah Data</span>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table
                            id="dataKelas"
                            class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kelas</th>
                                    <th>Semester</th>
                                    <th>Tahun Ajaran</th>
                                    <th>Tanggal Dibuat</th>
                                    <th>Tanggal Diupdate</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($kelas as $key => $value) { ?>
                                    <tr>
                                        <td><?= $key + 1; ?></td>
                                        <td><?= esc(trim($value->kelas_name ?? '')); ?></td>
                                        <td><?= esc(trim($value->semesterName ?? '')); ?></td>
                                        <td><?= esc(trim($value->tahunAjaran ?? '')); ?></td>
                                        <td><?= esc(trim($value->created_at ?? '-')); ?></td>
                                        <td><?= esc(trim($value->updated_at ?? '-')); ?></td>
                                        <td>
                                            <?= $value->is_active
                                                ? '<span class="badge badge-pill badge-success">Aktif</span>'
                                                : '<span class="badge badge-pill badge-secondary">Nonaktif</span>'
                                            ?>
                                        </td>
                                        <td>
                                            <button class="btn btn-warning btnEditKelas"
                                                data-id="<?= $value->id; ?>"
                                                data-kelas="<?= htmlspecialchars(trim($value->kelas_name), ENT_QUOTES) ?>"
                                                data-semester="<?= $value->semester_id; ?>"
                                                data-tahun_ajaran="<?= $value->tahun_ajaran_id; ?>"
                                                data-is_active="<?= $value->is_active; ?>">
                                                <i class="far fa-edit"></i>
                                            </button>
                                            <button class="btn btn-danger btnDeleteKelas"
                                                data-id="<?= $value->id; ?>">
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
<div class="modal fade" id="modalKelas" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalKelasLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalKelasLabel">-</h5>
            </div>
            <div class="modal-body">
                <!-- form -->
                <form id="formKelas">
                    <div class="form-group">
                        <label for="kelas">Nama Kelas</label>
                        <input type="text" name="kelas" class="form-control" id="kelas" placeholder="Nama Kelas" aria-describedby="kelas-error">
                        <span id="kelas-error" class="error invalid-feedback" style="display: none;"></span>
                    </div>
                    <div class="form-group">
                        <label for="semester">Semester</label>
                        <select class="form-control" id="semester" name="semester">
                            <?php foreach ($semester as $key => $value) { ?>
                                <option value="<?= $value['id']; ?>"><?= $value['semester_name']; ?></option>
                            <?php } ?>
                        </select>
                        <span id="semester-error" class="error invalid-feedback" style="display: none;"></span>
                    </div>
                    <div class="form-group">
                        <label for="tahun_ajaran">Tahun Ajaran</label>
                        <select class="form-control" id="tahun_ajaran" name="tahun_ajaran">
                            <?php foreach ($tahun_ajaran as $key => $value) { ?>
                                <option value="<?= $value['id']; ?>"><?= $value['tahun']; ?></option>
                            <?php } ?>
                        </select>
                        <span id="tahun_ajaran-error" class="error invalid-feedback" style="display: none;"></span>
                    </div>
                    <div id="status" class="form-group d-none">
                        <label for="is_active">Status</label>
                        <select class="form-control" id="is_active" name="is_active">
                            <option value="1">Aktif</option>
                            <option value="0">Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-end align-items-center">
                        <button id="cancelModal" type="button" class="btn btn-danger mr-2" data-dismiss="modal">Batal</button>
                        <button id="btnSubmitKelas" type="submit" class="btn btn-primary">-</button>
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
    // datatable
    $(function() {
        $("#dataKelas")
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
                        searchable: false,
                    },
                    {
                        targets: 5,
                        searchable: false,
                    },
                    {
                        targets: 6,
                        searchable: false,
                    },
                    {
                        targets: 7,
                        orderable: false,
                        className: 'text-center'
                    }
                ]
            })
    });

    $(function() {
        // function reset
        function reset() {
            $('#formKelas')[0].reset();
            $('#kelas').removeClass('is-invalid');
            $('#semester').removeClass('is-invalid');
            $('#semester option[value=""]').remove();
            $('#tahun_ajaran').removeClass('is-invalid');
            $('#tahun_ajaran option[value=""]').remove();
            $('#status').addClass('d-none');
            $('#kelas-error', '#semester-error', '#tahun_ajaran-error').text('').hide();
        }

        // modal tambah
        $('.btnTambahKelas').click(function() {
            modeModal = 'tambah';
            url = 'kelas/create-data';
            method = 'POST';

            $('#modalKelasLabel').text('Tambah Data');
            $('#btnSubmitKelas').text('Simpan');
            $('#semester').prepend('<option value="" selected disabled>Pilih Semester</option>');
            $('#tahun_ajaran').prepend('<option value="" selected disabled>Pilih Tahun Ajaran</option>');
            $('#modalKelas').modal('show');
        });

        // modal edit
        $('.btnEditKelas').click(function() {
            const id = $(this).data('id');
            const kelas = $(this).data('kelas');
            const semesterId = $(this).data('semester');
            const tahunAjaranId = $(this).data('tahun_ajaran');
            const isActive = $(this).data('is_active');
            modeModal = 'edit';
            url = 'kelas/update-data/' + id;
            method = 'POST';

            $('#modalKelasLabel').text('Edit Data');
            $('#btnSubmitKelas').text('Update');
            $('#status').removeClass('d-none');
            $('#kelas').val(kelas);
            $('#semester').val(semesterId);
            $('#tahun_ajaran').val(tahunAjaranId);
            $('#is_active').val(isActive);
            $('#modalKelas').modal('show');
        });

        // tambah dan update
        $('#formKelas').submit(function(e) {
            e.preventDefault();
            const data = $(this).serialize();

            $.ajax({
                url: url,
                method: method,
                data: data,
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
                        $('#kelas').removeClass('is-invalid');
                        $('#semester').removeClass('is-invalid');
                        $('#tahun_ajaran').removeClass('is-invalid');
                        $('#kelas-error', '#semester-error', '#tahun_ajaran-error').text('').hide();

                        for (const field in res.errors) {
                            const errorMsg = res.errors[field];
                            $('#' + field).addClass('is-invalid');
                            $('#' + field + '-error').text(errorMsg).show();
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
        $('.btnDeleteKelas').click(function() {
            const id = $(this).data('id')
            url = baseUrl + 'kelas/delete-data/' + id;
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
                                    text: 'Gagal menghapus data semester',
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
        $('#modalKelas').on('shown.bs.modal', function() {
            if (modeModal === 'tambah') {
                $('#kelas').trigger('focus');
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