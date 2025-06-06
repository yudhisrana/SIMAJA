<?= $this->extend('layouts/default') ?>

<?= $this->section('style'); ?>
<!-- DataTables -->
<link
    rel="stylesheet"
    href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css" />
<link
    rel="stylesheet"
    href="/plugins/datatables-responsive/css/responsive.bootstrap4.min.css" />
<link
    rel="stylesheet"
    href="/plugins/datatables-buttons/css/buttons.bootstrap4.min.css" />
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
                            <h3 class="card-title">Data Semester</h3>
                            <button class="btn btn-primary btnTambahSemester">
                                <i class="fas fa-plus mr-1"></i>
                                <span>Tambah Data</span>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table
                            id="dataSemester"
                            class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Semester</th>
                                    <th>Tanggal Dibuat</th>
                                    <th>Tanggal Diupdate</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($semester as $key => $value) { ?>
                                    <tr>
                                        <td><?= $key + 1; ?></td>
                                        <td><?= $value['semester_name']; ?></td>
                                        <td><?= $value['created_at']; ?></td>
                                        <td><?= $value['updated_at'] ?? "-"; ?></td>
                                        <td>
                                            <button class="btn btn-warning btnEditSemester"
                                                data-id="<?= $value['id']; ?>"
                                                data-semester="<?= htmlspecialchars($value['semester_name'], ENT_QUOTES) ?>">
                                                <i class="far fa-edit"></i>
                                            </button>
                                            <button class="btn btn-danger btnDeleteSemester"
                                                data-id="<?= $value['id']; ?>"
                                                data-semester="<?= htmlspecialchars($value['semester_name'], ENT_QUOTES) ?>">
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
<div class="modal fade" id="modalSemester" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalSemesterLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalSemesterLabel">-</h5>
            </div>
            <div class="modal-body">
                <!-- form -->
                <form id="formSemester">
                    <div class="form-group">
                        <label for="namaSemester">Nama Semester</label>
                        <input type="text" class="form-control" id="namaSemester" name="semester_name" placeholder="Semester 1 / Semester 2 dst">
                    </div>
                </form>

                <!-- confirm delete -->
                <div id="displayConfirmation" class="d-none">
                    <div class="d-flex flex-column justify-content-center align-items-center mt-2">
                        <h5><b>Yakin hapus data ini?</b></h5>
                        <p>data yang dihapus tidak dapat dikembalikan</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="cancelModal" type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                <button id="btnSubmitSemester" type="button" class="btn btn-primary">-</button>
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
<script>
    // datatable
    $(function() {
        $("#dataSemester")
            .DataTable({
                responsive: true,
                lengthChange: false,
                autoWidth: false,
            })
    });

    $(function() {
        let modeModal = '';

        // function reset
        function reset() {
            $('#formSemester')[0].reset();
            $('#formSemester').removeClass('d-none')
            $('#displayConfirmation').addClass('d-none');
            $('#cancelModal').removeClass('btn-secondary').addClass('btn-danger')
            $('#btnSubmitSemester').removeClass('btn-danger').addClass('btn-primary')
        }

        // modal tambah
        $('.btnTambahSemester').click(function() {
            modeModal = 'tambah';

            $('#modalSemesterLabel').text('Tambah Data');
            $('#btnSubmitSemester').text('Simpan');
            $('#modalSemester').modal('show');
        });

        // modal edit
        $('.btnEditSemester').click(function() {
            const semester = $(this).data('semester')
            modeModal = 'edit';

            $('#modalSemesterLabel').text('Edit Data');
            $('#btnSubmitSemester').text('Update');
            $('#namaSemester').val(semester)
            $('#modalSemester').modal('show');
        });

        // modal delete
        $('.btnDeleteSemester').click(function() {
            const semester = $(this).data('semester')
            modeModal = 'delete';

            $('#modalSemesterLabel').text('Delete Data');
            $('#btnSubmitSemester').text('Hapus');
            $('#formSemester').addClass('d-none')
            $('#displayConfirmation').removeClass('d-none');
            $('#cancelModal').removeClass('btn-danger').addClass('btn-secondary')
            $('#btnSubmitSemester').removeClass('btn-primary').addClass('btn-danger')
            $('#modalSemester').modal('show');
        });

        // focus input saat modal selesai ditampilkan
        $('#modalSemester').on('shown.bs.modal', function() {
            if (modeModal === 'tambah') {
                $('#namaSemester').trigger('focus');
            }
        });

        // reset batal
        $('#cancelModal').click(function() {
            reset();
        });
    });
</script>
<?= $this->endSection('script'); ?>