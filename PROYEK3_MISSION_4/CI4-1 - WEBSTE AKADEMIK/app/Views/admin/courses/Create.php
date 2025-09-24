<?= $this->extend('layouts/admin_template') ?>
<?= $this->section('content') ?>

<h1 class="mt-4">Tambah Mata Kuliah Baru</h1>

<form action="<?= base_url('admin/courses/store') ?>" method="post">
    <div class="mb-3">
        <label for="code" class="form-label">Kode Mata Kuliah</label>
        <input type="text" class="form-control" id="code" name="code" required>
    </div>
    <div class="mb-3">
        <label for="name" class="form-label">Nama Mata Kuliah</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>
    <div class="mb-3">
        <label for="credits" class="form-label">SKS</label>
        <input type="number" class="form-control" id="credits" name="credits" required>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
</form>

<?= $this->endSection() ?>