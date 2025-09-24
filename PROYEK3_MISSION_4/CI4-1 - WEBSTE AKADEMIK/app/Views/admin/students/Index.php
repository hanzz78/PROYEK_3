<?= $this->extend('layouts/admin_template') ?>
<?= $this->section('content') ?>

<h1 class="mt-4">Daftar Mahasiswa</h1>
<p><a href="<?= base_url('admin/students/create') ?>" class="btn btn-primary">Tambah Mahasiswa</a></p>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>NIM</th>
            <th>Nama Lengkap</th>
            <th>Umur</th>
            <th>Username</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($students as $student): ?>
        <tr>
            <td><?= $student['id'] ?></td>
            <td><?= $student['nim'] ?></td>
            <td><?= $student['nama_lengkap'] ?></td>
            <td><?= $student['umur'] ?></td>
            <td><?= $student['username'] ?></td>
            <td>
                <a href="<?= base_url('admin/students/delete/' . $student['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>