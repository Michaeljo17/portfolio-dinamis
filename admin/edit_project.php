<?php
// admin/edit_project.php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

require_once '../includes/db_connect.php';

// Periksa apakah ID proyek ada di URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Error: ID Proyek tidak disediakan.");
}
$project_id = $_GET['id'];

// 1. Ambil data teks dari tabel 'projects'
$stmt = $conn->prepare("SELECT id, title, short_description, long_description, technologies FROM projects WHERE id = ?");
$stmt->bind_param("i", $project_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows !== 1) {
    die("Proyek tidak ditemukan.");
}
$project = $result->fetch_assoc();
$stmt->close();

// 2. Ambil SEMUA gambar yang terhubung dari tabel 'project_images'
$images = [];
$imgStmt = $conn->prepare("SELECT id, image_url FROM project_images WHERE project_id = ? ORDER BY id ASC");
$imgStmt->bind_param("i", $project_id);
$imgStmt->execute();
$imgResult = $imgStmt->get_result();
while ($row = $imgResult->fetch_assoc()) {
    $images[] = $row;
}
$imgStmt->close();

$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Proyek</title>
    <link rel="stylesheet" href="../assets/css/admin_style.css">
    <style>
        .current-images-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
            margin-top: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .image-container {
            position: relative;
            border: 1px solid #ddd;
            padding: 5px;
        }
        .image-container img {
            width: 100%;
            height: auto;
            display: block;
        }
        .image-container .delete-checkbox {
            position: absolute;
            top: 10px;
            right: 10px;
            transform: scale(1.5); /* Membuat checkbox lebih besar dan mudah diklik */
        }
    </style>
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
                <label for="technologies">Teknologi</label>
                <input type="text" id="technologies" name="technologies" value="<?php echo htmlspecialchars($project['technologies']); ?>">
            </div>

            <div class="form-group">
                <label>Kelola Gambar Saat Ini</label>
                <?php if (!empty($images)): ?>
                    <div class="current-images-grid">
                        <?php foreach ($images as $image): ?>
                            <div class="image-container">
                                <img src="../<?php echo htmlspecialchars($image['image_url']); ?>" alt="Gambar saat ini">
                                <input type="checkbox" class="delete-checkbox" name="delete_images[]" value="<?php echo $image['id']; ?>" title="Tandai untuk hapus">
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <small>Centang gambar yang ingin Anda hapus.</small>
                <?php else: ?>
                    <p>Proyek ini belum memiliki gambar.</p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="add_images">Tambah Gambar Baru (opsional)</label>
                <input type="file" id="add_images" name="add_images[]" multiple accept="image/png, image/jpeg, image/jpg">
                <small>Pilih satu atau lebih gambar baru untuk ditambahkan.</small>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Update Proyek</button>
                <a href="manage_projects.php" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>