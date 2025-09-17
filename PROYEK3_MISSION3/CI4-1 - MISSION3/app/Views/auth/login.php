<!DOCTYPE html>
<html>
<head><title>Login</title></head>
<body>
<h2>Login</h2>
<?php echo view('partials/navbar'); ?>

<?php if(session()->getFlashdata('error')): ?>
<p style="color:red"><?= session()->getFlashdata('error') ?></p>
<?php endif; ?>
<form method="post" action="/login">
    <label>Email</label><input type="email" name="email"><br>
    <label>Password</label><input type="password" name="password"><br>
    <button type="submit">Login</button>
</form>
<p><a href="/register">Register</a></p>
</body>
</html>
