<?php
// admin/create_project.php
session_start();
// Keamanan: Pastikan admin sudah login
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Proyek Baru</title>
    <link rel="stylesheet" href="../assets/css/admin_style.css">
</head>
<body>
    <header class="admin-header">
        <h1><a href="dashboard.php">Admin Dashboard</a></h1>
        <a href="logout.php">Logout</a>
    </header>

    <div class="admin-container">
        <h2>Tambah Proyek Baru</h2>
        <form action="process_create.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Judul Proyek</label>
                <input type="text" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="short_description">Deskripsi Singkat (Tampil di awal)</label>
                <textarea id="short_description" name="short_description" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="long_description">Deskripsi Panjang (Detail saat diklik)</label>
                <textarea id="long_description" name="long_description" rows="6"></textarea>
            </div>
            <div class="form-group">
                <label for="technologies">Teknologi (pisahkan dengan koma)</label>
                <input type="text" id="technologies" name="technologies" placeholder="Contoh: HTML, CSS, PHP, JavaScript">
            </div>
            <div class="form-group">
                <label for="images">Gambar Proyek (Bisa pilih lebih dari satu)</label>
                <input type="file" id="images" name="images[]" multiple accept="image/png, image/jpeg, image/jpg" required>
                <small>Format yang didukung: PNG, JPG, JPEG.</small>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Simpan Proyek</button>
                <a href="manage_projects.php" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>