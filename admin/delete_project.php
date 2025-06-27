<?php
// admin/delete_project.php
session_start();
// Keamanan: Pastikan hanya admin yang login yang bisa mengakses skrip ini
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

// Pastikan ada ID proyek yang dikirim melalui URL
if (isset($_GET['id'])) {

    require_once '../includes/db_connect.php';

    $project_id = $_GET['id'];

    // --- SEBELUM MENGHAPUS DARI DATABASE, HAPUS SEMUA FILE GAMBARNYA DULU ---

    // 1. Ambil SEMUA path gambar dari tabel 'project_images' berdasarkan ID proyek
    $sql_select_images = "SELECT image_url FROM project_images WHERE project_id = ?";
    if ($stmt_select = $conn->prepare($sql_select_images)) {
        $stmt_select->bind_param("i", $project_id);
        $stmt_select->execute();
        $result = $stmt_select->get_result();

        // 2. Loop melalui setiap gambar dan hapus file fisiknya
        while ($row = $result->fetch_assoc()) {
            $image_path_to_delete = '../' . $row['image_url']; // Path relatif dari folder admin

            if (file_exists($image_path_to_delete)) {
                unlink($image_path_to_delete); // Fungsi unlink() untuk menghapus file
            }
        }
        $stmt_select->close();
    }

    // --- SEKARANG, HAPUS RECORD DARI TABEL `projects` ---
    // Karena kita menggunakan ON DELETE CASCADE, semua record di `project_images`
    // yang terhubung dengan project_id ini akan otomatis ikut terhapus.

    $sql_delete = "DELETE FROM projects WHERE id = ?";

    if ($stmt_delete = $conn->prepare($sql_delete)) {
        $stmt_delete->bind_param("i", $project_id);

        if ($stmt_delete->execute()) {
            // Jika berhasil, arahkan kembali ke halaman manajemen
            header("Location: manage_projects.php?status=success_delete");
            exit;
        } else {
            die("Error saat menghapus data proyek: " . $stmt_delete->error);
        }
        $stmt_delete->close();
    } else {
        die("Error saat mempersiapkan statement SQL: " . $conn->error);
    }

    $conn->close();

} else {
    // Jika tidak ada ID, tendang kembali ke halaman manajemen
    header("Location: manage_projects.php");
    exit;
}
?>