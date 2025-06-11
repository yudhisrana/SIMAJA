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
<section class="content pt-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- table -->
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title"><?= $table_name; ?></h3>
                            <button class="btn btn-primary btnTambahDosen">
                                <i class="fas fa-plus mr-1"></i>
                                <span>Tambah Data</span>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table
                            id="dataDosen"
                            class="table table-bordered table-striped display nowrap">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>NIDN</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>No Tlp</th>
                                    <th>Alamat</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Tanggal Dibuat</th>
                                    <th>Tanggal Diupdate</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($dosen as $key => $value) { ?>
                                    <tr>
                                        <td><?= $key + 1; ?></td>
                                        <td><?= esc(trim($value->name)); ?></td>
                                        <td><?= esc(trim($value->nidn)); ?></td>
                                        <td><?= esc(trim($value->username)); ?></td>
                                        <td><?= esc(trim($value->email)); ?></td>
                                        <td><?= esc(trim($value->phone)); ?></td>
                                        <td style="white-space: normal !important; word-wrap: break-word; min-width: 200px;">
                                            <?= esc(trim($value->address)); ?>
                                        </td>
                                        <td>
                                            <?= $value->gender == 'L'
                                                ? 'Laki - Laki'
                                                : 'Perempuan'
                                            ?>
                                        </td>
                                        <td>
                                            <?= $value->createdAt ? date('d-m-Y H:i:s', strtotime($value->createdAt)) : '-' ?>
                                        </td>
                                        <td>
                                            <?= $value->updatedAt ? date('d-m-Y H:i:s', strtotime($value->updatedAt)) : '-' ?>
                                        </td>
                                        <td>
                                            <?= $value->isActive
                                                ? '<span class="badge badge-pill badge-success">Aktif</span>'
                                                : '<span class="badge badge-pill badge-danger">Nonaktif</span>'
                                            ?>
                                        </td>
                                        <td>
                                            <button class="btn btn-warning btnEditDosen"
                                                data-id="<?= $value->id; ?>"
                                                data-name="<?= htmlspecialchars(trim($value->name), ENT_QUOTES); ?>"
                                                data-nidn="<?= htmlspecialchars(trim($value->nidn), ENT_QUOTES); ?>"
                                                data-username="<?= htmlspecialchars(trim($value->username), ENT_QUOTES); ?>"
                                                data-gender="<?= $value->gender; ?>"
                                                data-image="<?= $value->image; ?>"
                                                data-address="<?= htmlspecialchars(trim($value->address), ENT_QUOTES); ?>"
                                                data-is_active="<?= $value->isActive; ?>">
                                                <i class="far fa-edit"></i>
                                            </button>
                                            <button class="btn btn-danger btnDeleteDosen">
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
<div class="modal fade" id="modalDosen" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalDosen" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDosenLabel">-</h5>
            </div>
            <div class="modal-body">
                <!-- form -->
                <form id="formDosen">
                    <?= csrf_field(); ?>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="name">Nama Dosen</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Masukan nama dosen" aria-describedby="name-error">
                            <span id="name-error" class="error invalid-feedback" style="display: none;"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="nidn">NIDN</label>
                            <input type="text" name="nidn" class="form-control" id="nidn" placeholder="123456" aria-describedby="nidn-error">
                            <span id="nidn-error" class="error invalid-feedback" style="display: none;"></span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="username">Username</label>
                            <input type="text" name="username" class="form-control" id="username" placeholder="Masukan username" aria-describedby="username-error">
                            <span id="username-error" class="error invalid-feedback" style="display: none;"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="password">Password</label>
                            <input type="text" name="password" class="form-control" id="password" placeholder="******" aria-describedby="password-error">
                            <span id="password-error" class="error invalid-feedback" style="display: none;"></span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="gender">Jenis Kelamin</label>
                            <select class="form-control" id="gender" name="gender">
                                <option value="L">Laki - Laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                            <span id="gender-error" class="error invalid-feedback" style="display: none;"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="image">Image</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="image">
                                <label class="custom-file-label" for="image">Pilih image</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address">Alamat</label>
                        <textarea class="form-control" name="address" id="address"></textarea>
                    </div>
                    <div id="status" class="form-group d-none">
                        <label for="is_active">status</label>
                        <select class="form-control" id="is_active" name="is_active">
                            <option value="1">Aktif</option>
                            <option value="0">Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-end align-items-center">
                        <button id="cancelModal" type="button" class="btn btn-danger mr-2" data-dismiss="modal">Batal</button>
                        <button id="btnSubmitDosen" type="submit" class="btn btn-primary">-</button>
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
        $("#dataDosen")
            .DataTable({
                scrollX: true,
                responsive: false,
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
                        searchable: true,
                    },
                    {
                        targets: 3,
                        searchable: true,
                    },
                    {
                        targets: 4,
                        searchable: true,
                    },
                    {
                        targets: 5,
                        searchable: true,
                    },
                    {
                        targets: 6,
                        searchable: true,
                    },
                    {
                        targets: 7,
                        searchable: false,
                    },
                    {
                        targets: 8,
                        searchable: false,
                    },
                    {
                        targets: 9,
                        searchable: false,
                    },
                    {
                        targets: 10,
                        searchable: false,
                    },
                    {
                        targets: 11,
                        searchable: false,
                        orderable: false,
                        className: 'text-center'
                    },
                ]
            })
    });

    $(function() {
        // function reset
        function reset() {
            $('#formDosen')[0].reset();
            $('#name').removeClass('is-invalid');
            $('#nidn').removeClass('is-invalid');
            $('#username').removeClass('is-invalid');
            $('#password').removeClass('is-invalid');
            $('#gender').removeClass('is-invalid');
            $('#name', '#nidn', '#username', '#password', '#gender').text('').hide();
            $('#gender option[value=""]').remove();
            $('#status').addClass('d-none');
        }

        // modal tambah
        $('.btnTambahDosen').click(function() {
            modeModal = 'tambah';
            url = 'user/dosen/create-data';
            method = 'POST';

            $('#modalDosenLabel').text('Tambah Data');
            $('#btnSubmitDosen').text('Simpan');
            $('#gender').prepend('<option value="" selected disabled>Pilih jenis kelamin</option>')
            $('#modalDosen').modal('show');
        });

        // modal edit
        $('.btnEditDosen').click(function() {
            const id = $(this).data('id')
            const name = $(this).data('name');
            const nidn = $(this).data('nidn');
            const username = $(this).data('username');
            const gender = $(this).data('gender');
            const image = $(this).data('image');
            const address = $(this).data('address');
            const isActive = $(this).data('is_active');
            modeModal = 'edit';
            url = 'user/dosen/update-data/' + id;
            method = 'POST';

            $('#modalDosenLabel').text('Edit Data');
            $('#btnSubmitDosen').text('Update');
            $('#status').removeClass('d-none');
            $('#name').val(name);
            $('#nidn').val(nidn);
            $('#username').val(username);
            $('#gender').val(gender);
            $('#image').val(image);
            $('#address').val(address);
            $('#is_active').val(isActive);
            $('#modalDosen').modal('show');
        });

        // tambah dan update
        $('#formDosen').submit(function(e) {
            e.preventDefault();
            const name = $('#name').val();
            const nidn = $('#nidn').val();
            const username = $('#username').val();
            const password = $('#password').val();
            const gender = $('#gender').val();
            const image = $('#image').val();
            const address = $('#address').val();

            let isActive = 1;
            if (modeModal === 'edit') {
                isActive = $('#is_active').val();
            }

            $.ajax({
                url: baseUrl + url,
                method: method,
                data: {
                    [csrfToken]: csrfHash,
                    name: name,
                    nidn: nidn,
                    username: username,
                    password: password,
                    gender: gender,
                    image: image,
                    address: address,
                    is_active: isActive,
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
                        $('#name').removeClass('is-invalid');
                        $('#nidn').removeClass('is-invalid');
                        $('#username').removeClass('is-invalid');
                        $('#password').removeClass('is-invalid');
                        $('#gender').removeClass('is-invalid');
                        $('#name', '#nidn', '#username', '#password', '#gender').text('').hide();

                        for (const field in res.errors) {
                            const errorMsg = res.errors[field];
                            $('#' + field).addClass('is-invalid');
                            $('#' + field + '-error').text(errorMsg).show();
                        }
                    }
                },
                error: function(err) {
                    Swal.fire({
                        title: 'Opsss..',
                        text: err.responseJSON?.message,
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
        $('#modalDosen').on('shown.bs.modal', function() {
            if (modeModal === 'tambah') {
                $('#name').trigger('focus');
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