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

    // 1. Ambil semua data teks dari formulir
    $title = $_POST['title'];
    $short_desc = $_POST['short_description'];
    $long_desc = $_POST['long_description'];
    $techs = $_POST['technologies'];

    // 2. Simpan data teks ke tabel `projects` terlebih dahulu
    $stmt = $conn->prepare("INSERT INTO projects (title, short_description, long_description, technologies) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $title, $short_desc, $long_desc, $techs);

    // Eksekusi perintah dan periksa jika berhasil
    if ($stmt->execute()) {
        // Jika berhasil, dapatkan ID dari proyek yang baru saja kita buat
        $last_project_id = $stmt->insert_id;

        // 3. Sekarang, proses upload dan penyimpanan SETIAP GAMBAR
        $target_dir = "../uploads/"; // Folder tujuan

        // Buat folder 'uploads' jika belum ada
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        // Siapkan perintah SQL untuk menyimpan ke tabel BARU kita, `project_images`
        $imgStmt = $conn->prepare("INSERT INTO project_images (project_id, image_url) VALUES (?, ?)");

        // Periksa apakah ada file yang diupload (ingat nama 'images[]' dari form)
        if (isset($_FILES['images']) && !empty(array_filter($_FILES['images']['name']))) {

            // Lakukan perulangan untuk setiap file yang diupload
            foreach ($_FILES['images']['name'] as $key => $name) {
                // Buat nama file yang unik
                $image_name = time() . '_' . basename($_FILES["images"]["name"][$key]);
                $target_file = $target_dir . $image_name;

                // Pindahkan file ke folder 'uploads'
                if (move_uploaded_file($_FILES["images"]["tmp_name"][$key], $target_file)) {
                    // Simpan path relatifnya
                    $image_path = "uploads/" . $image_name;

                    // Hubungkan gambar ini dengan ID proyek, lalu simpan
                    $imgStmt->bind_param("is", $last_project_id, $image_path);
                    $imgStmt->execute();
                }
            }
        }

        $imgStmt->close(); // Tutup statement gambar

        // Jika semua proses selesai, arahkan ke halaman manajemen
        header("Location: manage_projects.php?status=success_create");
        exit;

    } else {
        die("Error saat menyimpan data proyek utama: " . $stmt->error);
    }

    // Tutup statement utama
    $stmt->close();

} else {
    // Jika tidak ada data POST, tendang ke dashboard
    header("Location: dashboard.php");
    exit;
}

// Tutup koneksi
$conn->close();
?>