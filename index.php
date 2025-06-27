<?php
/**
 * File: index.php
 * Deskripsi: Mengarahkan pengguna secara otomatis ke halaman login admin.
 * Author: [Nama Kamu/Gemini]
 * Tanggal: 26 Juni 2025
 */

// Mengatur header lokasi untuk pengalihan HTTP 302 (Found)
// Ini adalah pengalihan sementara, yang merupakan perilaku default untuk header Location.
header("Location: admin/login.php");

// Pastikan tidak ada output lain sebelum header ini dikirim.
// Exit() digunakan untuk menghentikan eksekusi skrip setelah pengalihan dikirim.
// Ini penting untuk mencegah kode lain dieksekusi dan potensi masalah pengiriman header.
exit();
?>