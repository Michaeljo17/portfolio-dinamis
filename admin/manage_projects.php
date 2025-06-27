<?php
// admin/manage_projects.php
session_start();

// Keamanan: Cek apakah admin sudah login
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

// 1. Sertakan file koneksi database
require_once '../includes/db_connect.php';

// 2. Ambil semua data proyek, GABUNGKAN dengan SATU gambar perwakilan
$sql = "
    SELECT 
        p.id, 
        p.title,
        (SELECT pi.image_url FROM project_images pi WHERE pi.project_id = p.id ORDER BY pi.id ASC LIMIT 1) as representative_image
    FROM 
        projects p 
    ORDER BY 
        p.id DESC
";
$result = $conn->query($sql);

// Siapkan array untuk menampung semua data proyek
$projects = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $projects[] = $row;
    }
}

// Siapkan pesan notifikasi jika ada
$status_message = '';
$message_type = '';
if(isset($_GET['status'])){
    if($_GET['status'] == 'success_create'){
        $status_message = "Proyek baru berhasil ditambahkan!";
        $message_type = 'success';
    } else if($_GET['status'] == 'success_edit'){
        $status_message = "Proyek berhasil diperbarui!";
        $message_type = 'success';
    } else if($_GET['status'] == 'success_delete'){
        $status_message = "Proyek berhasil dihapus!";
        $message_type = 'success';
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Proyek</title>
    <link rel="stylesheet" href="../assets/css/admin_style.css">
</head>
<body>
    <header class="admin-header">
        <h1><a href="dashboard.php">Admin Dashboard</a></h1>
        <a href="logout.php">Logout</a>
    </header>

    <div class="admin-container">
        <?php if ($status_message): ?>
        <div class="message <?php echo $message_type; ?>">
            <?php echo $status_message; ?>
        </div>
        <?php endif; ?>

        <div class="page-header">
            <h2>Manajemen Proyek</h2>
            <a href="create_project.php" class="btn btn-primary">Tambah Proyek Baru</a>
        </div>

        <?php if (count($projects) > 0): ?>
            <table class="projects-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Gambar</th>
                        <th>Judul</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($projects as $project): ?>
                        <tr>
                            <td><?php echo $project['id']; ?></td>
                            <td>
                                <?php if (!empty($project['representative_image'])): ?>
                                    <img src="../<?php echo htmlspecialchars($project['representative_image']); ?>" alt="Gambar Proyek">
                                <?php else: ?>
                                    <span>Tidak ada gambar</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($project['title']); ?></td>
                            <td class="actions">
                                <a href="edit_project.php?id=<?php echo $project['id']; ?>" class="btn-secondary">Edit</a>
                                <a href="delete_project.php?id=<?php echo $project['id']; ?>" class="btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus proyek ini?');">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="margin-top: 1.5rem;">Belum ada proyek. Silakan <a href="create_project.php">tambah proyek baru</a>.</p>
        <?php endif; ?>
    </div>
</body>
</html>