<?php
// admin/process_edit.php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

// Pastikan skrip ini diakses melalui metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    require_once '../includes/db_connect.php';

    // Ambil semua data dari formulir
    $project_id = $_POST['project_id'];
    $title = $_POST['title'];
    $short_desc = $_POST['short_description'];
    $long_desc = $_POST['long_description'];
    $techs = $_POST['technologies'];

    // --- PROSES 1: UPDATE DATA TEKS PROYEK ---
    $stmt_update_text = $conn->prepare("UPDATE projects SET title = ?, short_description = ?, long_description = ?, technologies = ? WHERE id = ?");
    $stmt_update_text->bind_param("ssssi", $title, $short_desc, $long_desc, $techs, $project_id);
    $stmt_update_text->execute();
    $stmt_update_text->close();

    // --- PROSES 2: HAPUS GAMBAR YANG DIPILIH (JIKA ADA) ---
    if (!empty($_POST['delete_images'])) {
        // Kita gunakan 'IN' clause untuk menghapus banyak gambar sekaligus, ini lebih efisien
        $images_to_delete_ids = $_POST['delete_images'];
        $placeholders = implode(',', array_fill(0, count($images_to_delete_ids), '?')); // Membuat placeholder ?,?,?

        // Ambil path file sebelum dihapus dari database
        $sql_select_paths = "SELECT image_url FROM project_images WHERE id IN ($placeholders)";
        $stmt_select = $conn->prepare($sql_select_paths);
        $stmt_select->bind_param(str_repeat('i', count($images_to_delete_ids)), ...$images_to_delete_ids);
        $stmt_select->execute();
        $result = $stmt_select->get_result();
        while($row = $result->fetch_assoc()){
            $file_to_delete = '../' . $row['image_url'];
            if(file_exists($file_to_delete)){
                unlink($file_to_delete); // Hapus file fisiknya
            }
        }
        $stmt_select->close();

        // Hapus record gambar dari database
        $sql_delete_images = "DELETE FROM project_images WHERE id IN ($placeholders)";
        $stmt_delete = $conn->prepare($sql_delete_images);
        $stmt_delete->bind_param(str_repeat('i', count($images_to_delete_ids)), ...$images_to_delete_ids);
        $stmt_delete->execute();
        $stmt_delete->close();
    }

    // --- PROSES 3: TAMBAH GAMBAR BARU (JIKA ADA) ---
    if (isset($_FILES['add_images']) && !empty(array_filter($_FILES['add_images']['name']))) {
        $target_dir = "../uploads/";

        $imgStmt_add = $conn->prepare("INSERT INTO project_images (project_id, image_url) VALUES (?, ?)");

        foreach ($_FILES['add_images']['name'] as $key => $name) {
            $image_name = time() . '_' . basename($_FILES["add_images"]["name"][$key]);
            $target_file = $target_dir . $image_name;

            if (move_uploaded_file($_FILES["add_images"]["tmp_name"][$key], $target_file)) {
                $image_path = "uploads/" . $image_name;
                $imgStmt_add->bind_param("is", $project_id, $image_path);
                $imgStmt_add->execute();
            }
        }
        $imgStmt_add->close();
    }

    // Jika semua proses selesai, arahkan kembali ke halaman manajemen
    header("Location: manage_projects.php?status=success_edit");
    exit;

} else {
    header("Location: dashboard.php");
    exit;
}

$conn->close();
?>