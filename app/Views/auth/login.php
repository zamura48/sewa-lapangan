<?= $this->extend('layouts/auth/app') ?>

<?= $this->section('content') ?>

<!-- Outer Row -->
<div class="row justify-content-center mt-5">

    <div class="col-xl-5 col-lg-12 col-md-9 mt-5">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="p-5">
                            <?= view('errors/_message_block') ?>
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                            </div>
                            <form class="user" action="<?= url_to('login') ?>" method="post">
                            <?= csrf_field() ?>
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user" id="exampleInputEmail"
                                        aria-describedby="emailHelp" name="email" placeholder="Enter Email Address...">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-user" name="password"
                                        id="exampleInputPassword" placeholder="Password">
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Login
                                </button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <p class="text-muted">Belum punya akun? <a href="<?= base_url('register') ?>">Daftar!</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<?= $this->endSection('content') ?>