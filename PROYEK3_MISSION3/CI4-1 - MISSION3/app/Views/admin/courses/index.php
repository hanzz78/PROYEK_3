<!DOCTYPE html>
<html>
<head><title>Manage Courses</title></head>
<body>
<h2>Manage Courses</h2>

<form method="post" action="/admin/courses/create">
    <input type="text" name="course_code" placeholder="Code">
    <input type="text" name="course_name" placeholder="Name">
    <input type="number" name="credits" placeholder="Credits">
    <button type="submit">Add</button>
</form>

<table border="1" cellpadding="5">
  <tr><th>Code</th><th>Name</th><th>Credits</th><th>Action</th></tr>
  <?php echo view('partials/navbar'); ?>
  <?php foreach($courses as $c): ?>
    <tr>
      <td><?= esc($c['course_code']) ?></td>
      <td><?= esc($c['course_name']) ?></td>
      <td><?= esc($c['credits']) ?></td>
      <td>
        <form method="post" action="/admin/courses/<?= $c['course_id'] ?>/delete">
            <?= csrf_field() ?>
            <button type="submit">Delete</button>
        </form>
      </td>
    </tr>
  <?php endforeach; ?>
</table>
</body>
</html>
