<?= $this->extend('layouts/user/app') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center mt-5 mb-5">
    <div class="col-md-6">
        <div class="card animate__animated animate__fadeIn">
            <div class="card-body">
                <form action="<?= base_url('pelanggan/profil') ?>" method="post">
                    <div class="form-group">
                        <label for="">Nama</label>
                        <input type="text" class="form-control" name="nama" value="<?= $data['nama'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="">No HP</label>
                        <input type="text" class="form-control" name="nohp" value="<?= $data['noHp'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="">Alamat</label>
                        <textarea class="form-control" name="alamat" id="" rows="2"><?= $data['alamat'] ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="email" class="form-control" name="email" value="<?= $data['email'] ?>">
                    </div>
                    <br>
                    <h5>Ubah Password</h5>
                    <div class="form-group">
                        <label for="">Password Lama</label>
                        <input type="password" class="form-control" name="passwordLama">
                    </div>
                    <div class="form-group">
                        <label for="">Password Baru</label>
                        <input type="password" class="form-control" name="passwordBaru">
                    </div>
                    <div class="form-group">
                        <label for="">Konfirmasi Password Lama</label>
                        <input type="password" class="form-control" name="passwordConfirm">
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