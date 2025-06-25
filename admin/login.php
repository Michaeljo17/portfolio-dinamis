<?php
// File: admin/login.php
session_start(); // Wajib ada di paling atas untuk menggunakan session

// Jika admin sudah login sebelumnya, langsung arahkan ke dashboard
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: dashboard.php");
    exit;
}

$error_message = '';

// Proses ini hanya berjalan ketika tombol login di-klik (metode POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // --- Username & Password Admin ---
    // Untuk sekarang, kita tulis langsung di kode. Ini aman untuk development.
    $admin_user = "admin";
    $admin_pass = "password123"; // Anda bisa ganti dengan password yang lebih kuat

    // Periksa apakah username dan password yang dimasukkan cocok
    if (isset($_POST['username']) && isset($_POST['password']) && $_POST['username'] === $admin_user && $_POST['password'] === $admin_pass) {
        // Jika login berhasil, simpan status login ke dalam session
        $_SESSION['admin_logged_in'] = true;
        // Arahkan ke halaman dashboard
        header("Location: dashboard.php");
        exit;
    } else {
        // Jika login gagal, siapkan pesan error
        $error_message = "Username atau password yang Anda masukkan salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Portofolio</title>
    <link rel="stylesheet" href="../assets/css/admin_style.css">
</head>
<body>
    <div class="login-container">
        <h1>Admin Panel Login</h1>
        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="login-button">Login</button>
        </form>
        <?php if (!empty($error_message)): ?>
            <p class="error-message"><?php echo $error_message; ?></p>
        <?php endif; ?>
    </div>
</body>
</html>