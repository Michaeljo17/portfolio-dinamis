<?php
// admin/process_create.php
session_start();
// Keamanan: Pastikan hanya admin yang login yang bisa mengakses skrip ini
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

// Skrip ini hanya akan berjalan jika ada data yang dikirim melalui metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Hubungkan ke database
    require_once '../includes/db_connect.php';

    // 1. Ambil semua data dari formulir
    $title = $_POST['title'];
    $short_desc = $_POST['short_description'];
    $long_desc = $_POST['long_description'];
    $techs = $_POST['technologies'];
    
    // 2. Proses Upload Gambar
    $image_path = ''; // Siapkan variabel path gambar
    if (isset($_FILES['project_image']) && $_FILES['project_image']['error'] == 0) {
        $target_dir = "../uploads/"; // Folder tujuan untuk menyimpan gambar

        // Buat folder 'uploads' jika belum ada
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        // Buat nama file yang unik untuk menghindari konflik nama file yang sama
        $image_name = time() . '_' . basename($_FILES["project_image"]["name"]);
        $target_file = $target_dir . $image_name;

        // Pindahkan file yang di-upload dari lokasi sementara ke folder tujuan
        if (move_uploaded_file($_FILES["project_image"]["tmp_name"], $target_file)) {
            // Jika berhasil, simpan path relatifnya untuk database
            $image_path = "uploads/" . $image_name;
        } else {
            die("Maaf, terjadi error saat mengupload file Anda.");
        }
    } else {
        die("Error: Tidak ada gambar yang diupload atau terjadi error saat upload.");
    }

    // 3. Simpan data ke Database menggunakan Prepared Statements (lebih aman dari SQL Injection)
    $sql = "INSERT INTO projects (title, short_description, long_description, technologies, image_path) VALUES (?, ?, ?, ?, ?)";
    
    if ($stmt = $conn->prepare($sql)) {
        // "sssss" berarti kita akan mengirim 5 data dengan tipe String
        $stmt->bind_param("sssss", $title, $short_desc, $long_desc, $techs, $image_path);
        
        // Eksekusi perintah
        if ($stmt->execute()) {
            // Jika berhasil, arahkan kembali ke halaman manajemen
            header("Location: manage_projects.php?status=success_create");
            exit;
        } else {
            die("Error saat menyimpan ke database: " . $stmt->error);
        }
        // Tutup statement
        $stmt->close();
    } else {
        die("Error saat mempersiapkan statement SQL: " . $conn->error);
    }

    // Tutup koneksi
    $conn->close();

} else {
    // Jika halaman ini diakses langsung tanpa mengirim data, tendang ke dashboard
    header("Location: dashboard.php");
    exit;
}
?>