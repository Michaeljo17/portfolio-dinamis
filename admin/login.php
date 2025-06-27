<?php
// File: admin/login.php (Versi Aman)
session_start(); 

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: dashboard.php");
    exit;
}

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // --- Konfigurasi Admin yang Aman ---
    $admin_user = "admin";
    
    // GANTI '....' DENGAN HASH YANG ANDA SALIN DARI generate_hash.php
    $hashed_pass = '$2y$10$yn06JNbe56pFpnj.48lRQezLkl7xP4GTPDTnNApOF1U.BhJp3ZuuC'; 

    // Memeriksa username dan memverifikasi hash password
    if (isset($_POST['username']) && isset($_POST['password']) && $_POST['username'] === $admin_user && password_verify($_POST['password'], $hashed_pass)) {
        // Jika login berhasil
        $_SESSION['admin_logged_in'] = true;
        header("Location: dashboard.php");
        exit;
    } else {
        // Jika login gagal
        $error_message = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        body { font-family: sans-serif; display: flex; justify-content: center; align-items: center; min-height: 100vh; background-color: #f0f2f5; margin: 0; }
        .login-container { padding: 2.5rem; background-color: white; border-radius: 8px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15); width: 100%; max-width: 400px; text-align: center; }
        .login-container h1 { margin-bottom: 1.5rem; color: #333; }
        .form-group { margin-bottom: 1rem; text-align: left; }
        .form-group label { display: block; margin-bottom: 0.5rem; color: #555; }
        .form-group input { width: 100%; padding: 0.8rem; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .login-button { width: 100%; padding: 0.8rem; border: none; border-radius: 4px; background-color: #007bff; color: white; font-size: 1rem; font-weight: bold; cursor: pointer; transition: background-color 0.3s ease; }
        .login-button:hover { background-color: #0056b3; }
        .error-message { color: #d93025; margin-top: 1rem; font-weight: bold; }
    </style>
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