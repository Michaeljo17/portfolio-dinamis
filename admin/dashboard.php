<?php
// admin/dashboard.php
session_start();

// Keamanan: Cek apakah admin sudah login. 
// Jika belum, "tendang" kembali ke halaman login.
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
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/admin_style.css">
</head>
<body>
    <header class="admin-header">
        <h1>Admin Dashboard</h1>
        <a href="logout.php">Logout</a>
    </header>

    <div class="admin-container">
        <h2>Selamat Datang, Admin!</h2>
        <p>Pilih menu di bawah untuk mulai mengelola konten website Anda.</p>
        
        <div class="dashboard-grid">
            <div class="dashboard-item">
                <h3>Kelola Proyek</h3>
                <p>Tambah, edit, atau hapus proyek portofolio Anda.</p>
                <a href="manage_projects.php">Kelola Proyek</a>
            </div>
            </div>
    </div>
</body>
</html>