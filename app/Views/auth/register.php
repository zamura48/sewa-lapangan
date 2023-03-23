<?= $this->extend('layouts/auth/app') ?>

<?= $this->section('content') ?>
<!-- Outer Row -->
<div class="row justify-content-center ">

    <div class="col-xl-5 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="p-5">

                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Buat Akun!</h1>
                            </div>
                            <form class="user" action="<?= base_url('register') ?>" method="post">
                                <?= csrf_field() ?>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user" id="nama" name="nama"
                                            placeholder="Nama Lengkap" value="<?= set_value('nama') ?>">
                                        <?php if (isset($validation)): ?>
                                            <small style="color: red;">
                                                <?= $validation->getError('nama'); ?>
                                            </small>
                                        <?php endif ?>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-user" id="noHp" name="noHp"
                                            placeholder="Nomor Telepon" value="<?= set_value('noHp') ?>">
                                        <?php if (isset($validation)): ?>
                                            <small style="color: red;">
                                                <?= $validation->getError('noHp'); ?>
                                            </small>
                                        <?php endif ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="alamat" name="alamat"
                                        placeholder="Alamat" value="<?= set_value('alamat') ?>">
                                    <?php if (isset($validation)): ?>
                                        <small style="color: red;">
                                            <?= $validation->getError('alamat'); ?>
                                        </small>
                                    <?php endif ?>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user" id="username"
                                            name="username" placeholder="Username" value="<?= set_value('username') ?>">
                                        <?php if (isset($validation)): ?>
                                            <small style="color: red;">
                                                <?= $validation->getError('username'); ?>
                                            </small>
                                        <?php endif ?>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="email" class="form-control form-control-user" id="email"
                                            name="email" placeholder="Email Address" value="<?= set_value('email') ?>">
                                        <?php if (isset($validation)): ?>
                                            <small style="color: red;">
                                                <?= $validation->getError('email'); ?>
                                            </small>
                                        <?php endif ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user" id="password"
                                            name="password" placeholder="Password">
                                        <?php if (isset($validation)): ?>
                                            <small style="color: red;">
                                                <?= $validation->getError('password'); ?>
                                            </small>
                                        <?php endif ?>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control form-control-user" id="pass_confirm"
                                            name="pass_confirm" placeholder="Repeat Password">
                                        <?php if (isset($validation)): ?>
                                            <small style="color: red;">
                                                <?= $validation->getError('pass_confirm'); ?>
                                            </small>
                                        <?php endif ?>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Daftar
                                </button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <p class="text-mute">Sudah punya akun? <a href="<?= base_url('login') ?>">Login!</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
<?= $this->endSection('content') ?>