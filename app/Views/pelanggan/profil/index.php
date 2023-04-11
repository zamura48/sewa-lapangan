<?= $this->extend('layouts/user/app') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center mt-5 mb-5">
    <div class="col-md-6">
        <div class="card animate__animated animate__fadeIn">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="d-flex justify-content-center">
                            <?php $deFoto = session('foto') === null ? "2.jpg" : session('foto'); ?>
                            <img class="profile-user-img img-fluid img-circle"
                                src="<?= base_url('uploads/profil/' . $deFoto) ?>" alt="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <form action="<?= base_url('pelanggan/profil/update-foto') ?>" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="">Foto</label>
                                <input type="file" class="form-control" id="foto" name="foto" accept=".jpg,.png,.jpeg">
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-warning">Perbarui</button>
                            </div>
                        </form>
                    </div>
                </div>
                <form action="<?= base_url('pelanggan/profil') ?>" method="post">
                    <h5>Data Pengguna</h5>
                    <div class="form-group">
                        <label for="">Nama <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nama" value="<?= $data['nama'] ?>">
                        <?php if (session()->has('validation')): ?>
                            <small style="color: red;">
                                <?= session('validation')['nama'] ?>
                            </small>
                        <?php endif ?>
                    </div>
                    <div class="form-group">
                        <label for="">No HP <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="noHp" value="<?= $data['noHp'] ?>">
                        <?php if (session()->has('validation')): ?>
                            <small style="color: red;">
                                <?= session('validation')['noHp'] ?>
                            </small>
                        <?php endif ?>
                    </div>
                    <div class="form-group">
                        <label for="">Alamat <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="alamat" id="" rows="2"><?= $data['alamat'] ?></textarea>
                        <?php if (session()->has('validation')): ?>
                            <small style="color: red;">
                                <?= session('validation')['alamat'] ?>
                            </small>
                        <?php endif ?>
                    </div>
                    <div class="form-group">
                        <label for="">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email" value="<?= $data['email'] ?>">
                        <?php if (session()->has('validation')): ?>
                            <small style="color: red;">
                                <?= session('validation')['email'] ?>
                            </small>
                        <?php endif ?>
                    </div>
                    <br>
                    <h5>Ubah Password</h5>
                    <div class="form-group">
                        <label for="">Password Lama</label>
                        <input type="password" class="form-control" name="passwordLama">
                        <?php if (session()->has('validation')): ?>
                            <small style="color: red;">
                                <?= session('validation')['passwordLama'] ?>
                            </small>
                        <?php endif ?>
                    </div>
                    <div class="form-group">
                        <label for="">Password Baru</label>
                        <input type="password" class="form-control" name="password">
                        <?php if (session()->has('validation')): ?>
                            <small style="color: red;">
                                <?= session('validation')['password'] ?>
                            </small>
                        <?php endif ?>
                    </div>
                    <div class="form-group">
                        <label for="">Konfirmasi Password Lama</label>
                        <input type="password" class="form-control" name="pass_confirm">
                        <?php if (session()->has('validation')): ?>
                            <small style="color: red;">
                                <?= session('validation')['pass_confirm'] ?>
                            </small>
                        <?php endif ?>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mt-4">
                            <div class="d-grid gap-2">
                                <a href="<?= base_url('pelanggan/pesan-lapangan') ?>" class="btn btn-danger">Kembali</a>
                            </div>
                        </div>
                        <div class="col-md-6 mt-4">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success">Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection('content') ?>

<?= $this->section('js') ?>
<?= view('layouts/alert') ?>
<?= $this->endSection('js') ?>