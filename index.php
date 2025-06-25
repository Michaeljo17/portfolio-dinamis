<?php
require_once 'includes/db_connect.php';
$sql = "SELECT id, title, short_description, long_description, technologies, image_path FROM projects ORDER BY created_at DESC";
$result = $conn->query($sql);
$projects = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $projects[] = $row;
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Portofolio Michael Jo Putra</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div id="blob"></div>
    <div class="cursor"></div>

    <div class="container">
        <header>
            <div class="logo">
                <a href="#">MJP</a>
            </div>
            <nav>
                <a href="#about">Tentang</a>
                <a href="#projects">Proyek</a>
                <a href="#contact">Kontak</a>
            </nav>
        </header>

        <main>
            <section class="hero">
                <h1>Halo, saya Michael Jo Putra</h1>
                <p>Web Developer & UI/UX Enthusiast</p>
                <a href="#projects" class="cta-button">Lihat Karya Saya</a>
            </section>

            <section id="about" class="section">
                <h2>Tentang Saya</h2>
                <div class="about-content">
                    <img src="assets/images/foto-saya.jpg" alt="Foto Profil Michael Jo Putra" class="profile-image">
                    <p>
                        Saya adalah seorang web developer dengan passion untuk menciptakan pengalaman digital yang bersih, modern, dan interaktif. Saya percaya bahwa perpaduan antara desain yang baik dan kode yang efisien adalah kunci untuk membangun produk yang luar biasa.
                    </p>
                </div>
            </section>

            <section id="projects" class="section">
                <h2>Proyek Pilihan</h2>
                <div class="project-grid">
                    <?php if (count($projects) > 0): ?>
                        <?php foreach ($projects as $project): ?>
                            <div class="project-card">
                                <img src="<?php echo htmlspecialchars($project['image_path']); ?>" alt="<?php echo htmlspecialchars($project['title']); ?>" class="project-image">
                                <h3><?php echo htmlspecialchars($project['title']); ?></h3>
                                <p><?php echo htmlspecialchars($project['short_description']); ?></p>
                                <div class="project-details-hidden">
                                    <h4>Teknologi yang Digunakan:</h4>
                                    <ul>
                                        <?php 
                                            $techs = explode(',', $project['technologies']);
                                            foreach ($techs as $tech) {
                                                echo '<li>' . htmlspecialchars(trim($tech)) . '</li>';
                                            }
                                        ?>
                                    </ul>
                                    <p><?php echo nl2br(htmlspecialchars($project['long_description'])); ?></p>
                                </div>
                                <a href="#">Lihat Detail &rarr;</a>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p style="text-align: center; width: 100%;">Belum ada proyek yang ditambahkan.</p>
                    <?php endif; ?>
                </div>
            </section>

            <section id="contact" class="section">
              <h2>Hubungi Saya</h2>
              <p>Tertarik untuk berkolaborasi atau sekadar menyapa?</p>
              <div class="social-links" style="margin-top: 2rem;">
                  <a href="https://www.linkedin.com/in/michaeljoputra" target="_blank"><i class='bx bxl-linkedin'></i></a>
                  <a href="https://www.instagram.com/mmichaelljo?igsh=MWExcnFwZWNwdmphbA%3D%3D&utm_source=qr" target="_blank"><i class='bx bxl-instagram'></i></a>
                  <a href="https://wa.me/6285273019053" target="_blank"><i class='bx bxl-whatsapp'></i></a>
                  <a href="mailto:michaeljoputra@gmail.com"><i class='bx bxs-envelope'></i></a>
              </div>
            </section>
        </main>

        <footer>
            <p>&copy; 2025 - Michael Jo Putra</p>
        </footer>
    </div>

    <script src="assets/js/main.js"></script>
</body>
</html>