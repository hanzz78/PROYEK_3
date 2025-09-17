<!DOCTYPE html>
<html>
<head>
    <style>
        nav {
            background: #000000ff;
            padding: 10px;
        }
        nav a {
            color: white;
            margin-right: 15px;
            text-decoration: none;
        }
        nav a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<nav>
    <?php if(session()->get('isLoggedIn')): ?>
        <span style="color:#ddd;">
            Hello, <?= esc(session()->get('full_name')) ?> (<?= esc(session()->get('role')) ?>)
        </span> |

        <?php if(session()->get('role') === 'admin'): ?>
            <a href="/admin/home">Home</a>
            <a href="/admin/courses">Manage Courses</a>
        <?php elseif(session()->get('role') === 'student'): ?>
            <a href="/student/home">Home</a>
            <a href="/student/courses">My Courses</a>
        <?php endif; ?>

        <a href="/logout">Logout</a>
    <?php else: ?>
        <a href="/login">Login</a>
        <a href="/register">Register</a>
    <?php endif; ?>
</nav>

</body>
</html>
