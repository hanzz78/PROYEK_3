<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        .sidebar {
            height: 100vh;
            background-color: #343a40;
            color: white;
            padding-top: 20px;
        }
        .sidebar a {
            color: #ccc;
            padding: 10px 15px;
            text-decoration: none;
            display: block;
        }
        .sidebar a:hover {
            background-color: #495057;
            color: white;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block sidebar">
            <div class="sidebar-sticky">
                <h4 class="text-white text-center">Admin Panel</h4>
                <ul class="nav flex-column mt-4">
                    <li class="nav-item">
                        <a href="<?= base_url('admin') ?>">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('admin/courses') ?>">Manajemen Mata Kuliah</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('admin/students') ?>">Manajemen Mahasiswa</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('logout') ?>">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <?= $this->renderSection('content') ?>
        </main>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>