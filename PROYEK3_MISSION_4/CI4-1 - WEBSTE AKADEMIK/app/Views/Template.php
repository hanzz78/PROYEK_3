<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Dashboard') ?></title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= site_url('/') ?>">Akademik App</a>
            <div class="d-flex">
                <?php if (session()->get('isLoggedIn')): ?>
                    <span class="navbar-text text-white me-3">
                        Hi, <?= esc(session()->get('username')) ?>
                    </span>
                    <a href="<?= site_url('logout') ?>" class="btn btn-outline-light btn-sm">Logout</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="container">
        <?= $this->renderSection('content') ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
