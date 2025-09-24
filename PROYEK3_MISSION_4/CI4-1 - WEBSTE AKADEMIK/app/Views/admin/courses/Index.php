<?= $this->extend('layouts/admin_template') ?>
<?= $this->section('content') ?>

<h1 class="mt-4">Daftar Mata Kuliah</h1>
<p><a href="<?= base_url('admin/courses/create') ?>" class="btn btn-primary">Tambah Mata Kuliah</a></p>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Kode</th>
            <th>Nama Mata Kuliah</th>
            <th>SKS</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($courses as $course): ?>
        <tr>
            <td><?= $course['id'] ?></td>
            <td><?= $course['code'] ?></td>
            <td><?= $course['name'] ?></td>
            <td><?= $course['credits'] ?></td>
            <td>
                <a href="<?= base_url('admin/courses/delete/' . $course['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>