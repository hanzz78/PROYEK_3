<?= $this->extend('layouts/student_template') ?>
<?= $this->section('content') ?>

<h1 class="mt-4">Mata Kuliah yang Diambil</h1>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Kode Mata Kuliah</th>
            <th>Nama Mata Kuliah</th>
            <th>SKS</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($enrollments as $enrollment): ?>
        <tr>
            <td><?= $enrollment['code'] ?></td>
            <td><?= $enrollment['name'] ?></td>
            <td><?= $enrollment['credits'] ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>