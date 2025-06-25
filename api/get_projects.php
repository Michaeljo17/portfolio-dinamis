<?php
// File: api/get_projects.php

// --- PENTING UNTUK KONEKSI ANTAR PROYEK ---
// Memberitahu browser bahwa konten yang dikirim adalah JSON
header('Content-Type: application/json');
// Memberi izin akses dari sumber mana pun (*). Ini penting agar Vite (di port lain) bisa mengakses.
header('Access-Control-Allow-Origin: *');

// 1. Sertakan file koneksi database
require_once '../includes/db_connect.php';

// 2. Siapkan query SQL untuk mengambil semua data proyek
$sql = "SELECT id, title, short_description, long_description, technologies, image_path FROM projects ORDER BY created_at DESC";

// 3. Jalankan query
$result = $conn->query($sql);

// 4. Siapkan array untuk menampung data
$projects = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Untuk path gambar, kita tambahkan alamat domain lengkap agar bisa diakses dari mana saja
        $row['image_path'] = 'http://localhost/portofolio-dinamis/' . $row['image_path'];
        $projects[] = $row;
    }
}

// 5. Tutup koneksi
$conn->close();

// 6. "Cetak" data dalam format JSON
echo json_encode($projects);

?>