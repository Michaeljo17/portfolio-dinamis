<?php
// admin/delete_project.php
session_start();
// Keamanan: Pastikan hanya admin yang login yang bisa mengakses skrip ini
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

// Pastikan ada ID proyek yang dikirim melalui URL (metode GET)
if (isset($_GET['id'])) {
    
    require_once '../includes/db_connect.php';
    
    $project_id = $_GET['id'];

    // --- SEBELUM MENGHAPUS DARI DATABASE, HAPUS FILE GAMBARNYA DULU ---
    // 1. Ambil path gambar dari database berdasarkan ID
    $sql_select = "SELECT image_path FROM projects WHERE id = ?";
    if($stmt_select = $conn->prepare($sql_select)){
        $stmt_select->bind_param("i", $project_id);
        $stmt_select->execute();
        $result = $stmt_select->get_result();
        if($row = $result->fetch_assoc()){
            $image_path_to_delete = '../' . $row['image_path'];
            
            // 2. Hapus file gambar dari server jika file tersebut ada
            if (file_exists($image_path_to_delete)) {
                unlink($image_path_to_delete); // Fungsi unlink() untuk menghapus file
            }
        }
        $stmt_select->close();
    }
    
    // --- SEKARANG, HAPUS RECORD DARI DATABASE ---
    $sql_delete = "DELETE FROM projects WHERE id = ?";
    
    if ($stmt_delete = $conn->prepare($sql_delete)) {
        // "i" berarti kita mengirim data dengan tipe Integer
        $stmt_delete->bind_param("i", $project_id);
        
        // Eksekusi perintah hapus
        if ($stmt_delete->execute()) {
            // Jika berhasil, arahkan kembali ke halaman manajemen dengan pesan sukses
            header("Location: manage_projects.php?status=success_delete");
            exit;
        } else {
            die("Error saat menghapus data: " . $stmt_delete->error);
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