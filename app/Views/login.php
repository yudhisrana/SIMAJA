<?= $this->extend('layouts/auth'); ?>

<?= $this->section('content'); ?>
<!-- /.login-logo -->
<div class="card card-outline card-primary">
    <div class="card-header text-center">
        <h1>
            <strong>SIMAJA</strong>
        </h1>
    </div>
    <!-- /.Form Login -->
    <div class="card-body">
        <p class="login-box-msg">Login untuk masuk ke sistem</p>
        <form action="#" method="post">
            <div class="input-group mb-3">
                <input type="email" class="form-control" placeholder="Email" />
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <input
                    type="password"
                    class="form-control"
                    placeholder="Password" />
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-block">
                        Sign In
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection('content'); ?>