<?= $this->include('template/header') ?>

<div class="container mt-4">
    <h2>Selamat Datang, <?= session()->get('username'); ?> 👋</h2>
    <p>Silakan pilih menu di bawah ini:</p>

    <ul>
        <li><a href="/student/courses">Lihat & Enroll Mata Kuliah</a></li>
        <li><a href="/student/mycourses">Mata Kuliah Saya</a></li>
        <li><a href="/logout">Logout</a></li>
    </ul>
</div>

<?= $this->include('template/footer') ?>
