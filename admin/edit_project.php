<?php
// admin/edit_project.php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

require_once '../includes/db_connect.php';

$project_id = $_GET['id'];
$project = null;

// Ambil data proyek yang ada dari database berdasarkan ID
if (isset($project_id)) {
    $sql = "SELECT id, title, short_description, long_description, technologies, image_path FROM projects WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $project_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            $project = $result->fetch_assoc();
        } else {
            die("Proyek tidak ditemukan.");
        }
        $stmt->close();
    }
} else {
    die("ID Proyek tidak valid.");
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Proyek</title>
    <link rel="stylesheet" href="../assets/css/admin_style.css">
</head>
<body>
    <header class="admin-header">
        <h1><a href="dashboard.php">Admin Dashboard</a></h1>
        <a href="logout.php">Logout</a>
    </header>

    <div class="admin-container">
        <h2>Edit Proyek: <?php echo htmlspecialchars($project['title']); ?></h2>
        <form action="process_edit.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="project_id" value="<?php echo $project['id']; ?>">
            
            <div class="form-group">
                <label for="title">Judul Proyek</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($project['title']); ?>" required>
            </div>
            <div class="form-group">
                <label for="short_description">Deskripsi Singkat</label>
                <textarea id="short_description" name="short_description" rows="3" required><?php echo htmlspecialchars($project['short_description']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="long_description">Deskripsi Panjang</label>
                <textarea id="long_description" name="long_description" rows="6"><?php echo htmlspecialchars($project['long_description']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="technologies">Teknologi (pisahkan dengan koma)</label>
                <input type="text" id="technologies" name="technologies" value="<?php echo htmlspecialchars($project['technologies']); ?>">
            </div>
            <div class="form-group">
                <label>Gambar Saat Ini</label><br>
                <img src="../<?php echo htmlspecialchars($project['image_path']); ?>" alt="Gambar saat ini" class="current-image">
            </div>
            <div class="form-group">
                <label for="project_image">Ganti Gambar (opsional)</label>
                <input type="file" id="project_image" name="project_image" accept="image/png, image/jpeg, image/jpg">
                <small>Kosongkan jika tidak ingin mengganti gambar.</small>
            </div>
            <button type="submit" class="btn btn-primary">Update Proyek</button>
            <a href="manage_projects.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>
</html>