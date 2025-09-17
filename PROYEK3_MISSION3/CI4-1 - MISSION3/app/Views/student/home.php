<!DOCTYPE html>
<html>
<head><title>Student Home</title></head>
<body>
<?php echo view('partials/navbar'); ?>

<h2>Halo, <?= esc(session()->get('full_name')) ?></h2>
<p>Selamat datang di halaman mahasiswa.</p>

</body>
</html>
