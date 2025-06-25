<?php
// File: /includes/db_connect.php

// --- Pengaturan Database ---
$db_host = "localhost";    // Nama host, biasanya "localhost"
$db_user = "root";         // Username database, default XAMPP adalah "root"
$db_pass = "";             // Password database, default XAMPP adalah kosong
$db_name = "portfolio_db"; // Nama database yang kita buat tadi

// --- Membuat Koneksi ---
// Kita menggunakan ekstensi MySQLi (MySQL Improved)
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// --- Memeriksa Koneksi ---
// Jika terjadi error saat mencoba terhubung, hentikan skrip dan tampilkan pesan error.
if ($conn->connect_error) {
  die("Koneksi ke database gagal: " . $conn->connect_error);
}

// Mengatur set karakter ke utf8mb4 untuk mendukung berbagai macam karakter
$conn->set_charset("utf8mb4");

// Jika berhasil, variabel $conn sekarang siap digunakan
// untuk menjalankan query ke database di file-file lain.
?>