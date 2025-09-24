<?= $this->extend('layouts/admin_template') ?>
<?= $this->section('content') ?>

<h1 class="mt-4">Tambah Mahasiswa Baru</h1>

<form action="<?= base_url('admin/students/store') ?>" method="post">
    <div class="mb-3">
        <label for="nim" class="form-label">NIM</label>
        <input type="text" class="form-control" id="nim" name="nim" required>
    </div>
    <div class="mb-3">
        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required>
    </div>
    <div class="mb-3">
        <label for="umur" class="form-label">Umur</label>
        <input type="number" class="form-control" id="umur" name="umur" required>
    </div>
    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
</form>

<?= $this->endSection() ?>