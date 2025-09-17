<!DOCTYPE html>
<html>
<head><title>Admin Home</title></head>
<body>
<?php echo view('partials/navbar'); ?>

<h2>Halo Admin, <?= esc(session()->get('full_name')) ?></h2>
<p>Selamat datang di dashboard Admin.</p>

</body>
</html>
