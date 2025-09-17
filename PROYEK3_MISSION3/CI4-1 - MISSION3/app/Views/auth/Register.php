<!DOCTYPE html>
<html>
<head><title>Register</title></head>
<body>
<h2>Register</h2>
<?php echo view('partials/navbar'); ?>
<form method="post" action="/register">
    <label>Full Name</label><input type="text" name="full_name"><br>
    <label>Email</label><input type="email" name="email"><br>
    <label>Password</label><input type="password" name="password"><br>
    <button type="submit">Register</button>
</form>
</body>
</html>
