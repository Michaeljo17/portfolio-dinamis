<?php
// Atur header agar outputnya berupa JSON dan bisa diakses dari mana saja
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

// Panggil file koneksi database Anda
include '../includes/db_connect.php';

// Query SQL untuk menggabungkan data dari dua tabel
$sql = "
    SELECT 
        p.id, 
        p.title, 
        p.short_description,
        p.long_description,
        p.technologies,
        GROUP_CONCAT(pi.image_url) AS imageUrls 
    FROM 
        projects p
    LEFT JOIN 
        project_images pi ON p.id = pi.project_id
    GROUP BY 
        p.id
    ORDER BY
        p.id DESC;
";

$result = $conn->query($sql);

$projects = [];
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Ubah string gambar yang dipisah koma menjadi array
        $row['imageUrls'] = $row['imageUrls'] ? explode(',', $row['imageUrls']) : [];
        
        // --- INI ADALAH BAGIAN PALING PENTING UNTUK DIPERBAIKI ---
        // Kita gunakan URL dasar yang pasti benar untuk XAMPP
        $base_url = 'http://localhost/portofolio-dinamis/';
        // -----------------------------------------------------------

        // Gabungkan URL dasar dengan path relatif dari setiap gambar
        // Contoh: 'http://localhost/portfolio-dinamis/' + 'uploads/namafile.jpg'
        $row['imageUrls'] = array_map(function($path) use ($base_url) {
            return $base_url . $path;
        }, $row['imageUrls']);

        $projects[] = $row;
    }
}

// Cetak hasil akhir dalam format JSON
echo json_encode($projects, JSON_PRETTY_PRINT);

$conn->close();
?>