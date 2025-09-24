<?= $this->include('template/header') ?>

<div class="container">
    <h2>Edit Mahasiswa</h2>

    <form action="/admin/students/update/<?= $student['nim'] ?>" method="post">
        <div>
            <label for="nim">NIM</label><br>
            <input type="text" id="nim" name="nim" value="<?= $student['nim'] ?>" required>
        </div>
        <br>

        <div>
            <label for="nama_lengkap">Nama Lengkap</label><br>
            <input type="text" id="nama_lengkap" name="nama_lengkap" value="<?= $student['nama_lengkap'] ?>" required>
        </div>
        <br>
        <br>

        <button type="submit">Update</button>
        <a href="/admin/students">Batal</a>
    </form>
</div>

<?= $this->include('template/footer') ?>
