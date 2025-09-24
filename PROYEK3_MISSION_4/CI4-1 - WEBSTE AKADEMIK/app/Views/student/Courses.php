<?= $this->extend('layouts/student_template') ?>
<?= $this->section('content') ?>

<h1 class="mt-4">Daftar Mata Kuliah</h1>

<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Kode</th>
            <th>Nama Mata Kuliah</th>
            <th>SKS</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($courses as $course): ?>
        <tr>
            <td><?= $course['code'] ?></td>
            <td><?= $course['name'] ?></td>
            <td><?= $course['credits'] ?></td>
            <td>
                <?php if (in_array($course['id'], $enrolledCourses)): ?>
                    <span class="text-success">Sudah Di-enroll</span>
                <?php else: ?>
                    <form action="<?= base_url('student/enroll') ?>" method="post">
                        <input type="hidden" name="course_id" value="<?= $course['id'] ?>">
                        <button type="submit" class="btn btn-success btn-sm">Enroll</button>
                    </form>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>