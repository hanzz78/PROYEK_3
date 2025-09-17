<!DOCTYPE html>
<html>
<head><title>Courses</title></head>
<body>
<?php echo view('partials/navbar'); ?>

<h2>Available Courses</h2>
<?php if(session()->getFlashdata('success')): ?>
    <p style="color:green"><?= session()->getFlashdata('success') ?></p>
<?php endif; ?>
<?php if(session()->getFlashdata('error')): ?>
    <p style="color:red"><?= session()->getFlashdata('error') ?></p>
<?php endif; ?>

<table border="1" cellpadding="5">
  <tr><th>Code</th><th>Name</th><th>Credits</th><th>Action</th></tr>
  <?php foreach($courses as $c): ?>
    <tr>
      <td><?= esc($c['course_code']) ?></td>
      <td><?= esc($c['course_name']) ?></td>
      <td><?= esc($c['credits']) ?></td>
      <td>
        <?php if(in_array($c['course_id'], $enrolledIds)): ?>
          Enrolled
        <?php else: ?>
          <form method="post" action="/student/courses/<?= $c['course_code'] ?>/enroll">
            <button type="submit">Enroll</button>
          </form>
        <?php endif; ?>
      </td>
    </tr>
  <?php endforeach; ?>
</table>

<h3>Total Mata Kuliah: <?= $totalEnrolled ?></h3>
<h3>Total SKS: <?= $totalCredits ?></h3>

</body>
</html>
