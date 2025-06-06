<?= $this->extend('layouts/default') ?>

<?= $this->section('content') ?>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <?php foreach ($semester as $key => $value) {  ?>
                    <li>
                        <?= $value->semester_name; ?>
                    </li>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection('content') ?>