<?php
// admin/process_edit.php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    require_once '../includes/db_connect.php';

    // Ambil semua data dari formulir, termasuk ID proyek
    $project_id = $_POST['project_id'];
    $title = $_POST['title'];
    $short_desc = $_POST['short_description'];
    $long_desc = $_POST['long_description'];
    $techs = $_POST['technologies'];
    
    // Siapkan query UPDATE dasar
    $sql = "UPDATE projects SET title=?, short_description=?, long_description=?, technologies=? WHERE id=?";
    
    // --- Cek apakah ada gambar baru yang diupload ---
    if (isset($_FILES['project_image']) && $_FILES['project_image']['error'] == 0) {
        
        // 1. Hapus gambar lama dulu
        $sql_old_img = "SELECT image_path FROM projects WHERE id = ?";
        $stmt_old_img = $conn->prepare($sql_old_img);
        $stmt_old_img->bind_param("i", $project_id);
        $stmt_old_img->execute();
        $result = $stmt_old_img->get_result();
        if($row = $result->fetch_assoc()){
            $old_image_path = '../' . $row['image_path'];
            if (file_exists($old_image_path)) {
                unlink($old_image_path);
            }
        }
        $stmt_old_img->close();

        // 2. Upload gambar baru
        $target_dir = "../uploads/";
        $image_name = time() . '_' . basename($_FILES["project_image"]["name"]);
        $target_file = $target_dir . $image_name;
        if (move_uploaded_file($_FILES["project_image"]["tmp_name"], $target_file)) {
            $new_image_path = "uploads/" . $image_name;
            // Jika ada gambar baru, sertakan pembaruan path gambar di query SQL
            $sql = "UPDATE projects SET title=?, short_description=?, long_description=?, technologies=?, image_path=? WHERE id=?";
        }
    }

    // Persiapkan statement SQL
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameter sesuai dengan query yang digunakan
        if (isset($new_image_path)) {
            $stmt->bind_param("sssssi", $title, $short_desc, $long_desc, $techs, $new_image_path, $project_id);
        } else {
            $stmt->bind_param("ssssi", $title, $short_desc, $long_desc, $techs, $project_id);
        }
        
        // Eksekusi
        if ($stmt->execute()) {
            header("Location: manage_projects.php?status=success_edit");
            exit;
        } else {
            die("Error saat mengupdate data: " . $stmt->error);
        }
        $stmt->close();
    } else {
        die("Error saat mempersiapkan statement SQL: " . $conn->error);
    }

    $conn->close();

} else {
    header("Location: dashboard.php");
    exit;
}
?>