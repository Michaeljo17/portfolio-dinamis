<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/svg+xml" href="/vite.svg" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Portfolio Michael Jo Putra</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        /* Gaya untuk teks justify di bagian about-content */
        .about-content p {
            text-align: justify;
            line-height: 1.6;
        }

        /* Gaya lainnya */
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.8s ease-out, transform 0.8s ease-out;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Gaya untuk bagian Skills */
        #skills {
            text-align: center;
        }

        .skills-categories-container {
            display: flex;
            flex-direction: column;
            gap: 3rem; /* Jarak antar kategori */
            margin-top: 2rem;
        }

        .skill-category {
            background-color: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 2rem;
        }

        .skill-category h3 {
            margin-bottom: 2rem;
            font-size: 1.5rem;
            color: #00ffff;
            text-align: left;
            border-bottom: 2px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 0.5rem;
        }

        .skills-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 1.5rem;
        }

        .skill-item {
            background-color: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 1.5rem 1rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: transform 0.3s ease, background-color 0.3s ease;
            text-align: center;
        }

        .skill-item:hover {
            transform: translateY(-5px);
            background-color: rgba(255, 255, 255, 0.15);
        }

        .skill-item i {
            font-size: 2.5rem;
            color: #ffffff; /* Warna ikon menjadi putih agar kontras */
            margin-bottom: 0.75rem;
        }

        .skill-item span {
            font-size: 0.9rem;
            font-weight: 500;
        }
    </style>
  </head>
  <body>
    <div id="blob"></div>
    <div class="cursor"></div>
    <div class="cursor"></div>

    <div class="container">
      <header>
        <div class="logo">
          <a href="#">Michael Jo Putra</a>
        </div>
        <nav>
          <a href="#about">About Me</a>
          <a href="#skills">Skills</a>
          <a href="#projects">Project</a>
          <a href="#contact">Contact</a>
        </nav>
      </header>

      <main>
        <section class="hero">
          <h1 class="fade-in">Hello, i'm Michael Jo Putra</h1>
          <p class="fade-in">Information System Student, State University of Surabaya</p>
          <a href="#projects" class="cta-button fade-in">see my work</a>
        </section>

        <section id="about" class="section">
          <h2 class="fade-in">About Me</h2>
          <div class="about-content">
              <img src="assets/foto-saya.jpg" alt="Foto Profil Saya" class="profile-image fade-in">
              <p class="fade-in">
                  Hello! My name is Michael Jo Putra, an active 5th-semester Information System student at State University of Surabaya. I have a strong interest and focus on Information Management Systems, combining technical understanding with solid organizational skills.
                  I possess a strong foundation in full-stack web development with expertise in HTML, CSS, JavaScript, PHP, MySQL, React.js, Laravel, Node.js, and API. My experience includes developing a personal financial management web application called "BudgetIn" which features secure authentication, transaction logging, and interactive data visualization , as well as designing and implementing a database system for coffee shop sales management. I have also built a comprehensive e-commerce furniture website with an intuitive admin dashboard and API integration , and developed a responsive personal portfolio website using React.js and Tailwind CSS.
                  Furthermore, I am proficient in data analysis using tools like SPSS, Microsoft Excel, and Python. I also have experience in ERP system implementation using the EA application, demonstrated through a comprehensive sales and marketing analysis project focused on PT Indofood. My understanding extends to the COBIT 2019 framework for IT risk management, as applied in a project for PT Kreasi Now.                      
                  Beyond my technical expertise, I have significant experience in event logistics coordination for both university and high school events. I am known for being adaptable, collaborative, solution-oriented, and possessing strong problem-solving and critical thinking skills.
                  I am highly enthusiastic about continuously learning and applying my skills in innovative projects. This portfolio serves as a testament to my dedication to creating efficient and impactful solutions.
              </p>
          </div>
        </section>

        <section id="skills" class="section">
            <h2 class="fade-in">My Skills</h2>
            <div class="skills-categories-container">

                <div class="skill-category fade-in">
                    <h3>Web Development</h3>
                    <div class="skills-grid">
                        <div class="skill-item"><i class='bx bxl-html5'></i><span>HTML</span></div>
                        <div class="skill-item"><i class='bx bxl-css3'></i><span>CSS</span></div>
                        <div class="skill-item"><i class='bx bxl-javascript'></i><span>JavaScript</span></div>
                        <div class="skill-item"><i class='bx bxl-react'></i><span>React.js</span></div>
                        <div class="skill-item"><i class='bx bxl-nodejs'></i><span>Node.js</span></div>
                        <div class="skill-item"><i class='bx bxl-php'></i><span>PHP</span></div>
                        <div class="skill-item"><i class='bx bxl-laravel'></i><span>Laravel</span></div>
                        <div class="skill-item"><i class='bx bxs-data'></i><span>MySQL</span></div>
                    </div>
                </div>

                <div class="skill-category fade-in">
                    <h3>Data Analysis, Data Entry & Visualization</h3>
                    <div class="skills-grid">
                        <div class="skill-item"><i class='bx bxl-python'></i><span>Python</span></div>
                        <div class="skill-item"><i class='bx bxs-file-spreadsheet'></i><span>Ms. Excel</span></div>
                        <div class="skill-item"><i class='bx bxs-bar-chart-alt-2'></i><span>SPSS</span></div>
                        <div class="skill-item"><i class='bx bxs-bar-chart-square'></i><span>Tableau</span></div>
                        <div class="skill-item"><i class='bx bxs-widget'></i><span>Power BI</span></div>
                    </div>
                </div>

                <div class="skill-category fade-in">
                    <h3>BPMN, ERP & System Design</h3>
                    <div class="skills-grid">
                        <div class="skill-item"><i class='bx bxs-vector'></i><span>Draw.io</span></div>
                        <div class="skill-item"><i class='bx bx-network-chart'></i><span>Bizagi</span></div>
                        <div class="skill-item"><i class='bx bx-sitemap'></i><span>SparX EA</span></div>
                        <div class="skill-item"><i class='bx bx-shield-quarter'></i><span>COBIT 2019</span></div>
                    </div>
                </div>

            </div>
        </section>
        <section id="projects" class="section">
            <h2 class="fade-in">Project</h2>
            <div class="project-grid">
            </div>
        </section>
        
        <section id="contact" class="section">
          <h2 class="fade-in">Contact Me</h2>
          <p class="fade-in">If you are interest in working together or more information, please send me an email!</p>
          <a href="mailto:michaeljoputra@gmail.com" class="cta-button fade-in">michaeljoputra@gmail.com</a>
        </section>
      </main>

      <footer>
        <div class="social-links">
          <a href="https://www.linkedin.com/in/michaeljoputra" target="_blank"><i class='bx bxl-linkedin'></i></a>
          <a href="https://www.instagram.com/mmichaelljo?igsh=MWExcnFwZWNwdmphbA%3D%3D&utm_source=qr" target="_blank"><i class='bx bxl-instagram'></i></a>
          <a href="https://wa.me/6285273019053" target="_blank"><i class='bx bxl-whatsapp'></i></a>
        </div>
        <p>&copy; 2025 - <span style="color: #ff4757;">&hearts;</span> Michael Jo Putra</p>
      </footer>
    </div>

    <div id="project-modal" class="modal-overlay">
        <div class="modal-content">
            <button class="modal-close-btn">&times;</button>
            <div class="modal-body">
                <div class="modal-gallery">
                </div>
                <div class="modal-details">
                    <h2 id="modal-title">Project title</h2>
                    <h4>Tools:</h4>
                    <p id="modal-technologies">HTML, CSS, JavaScript</p>
                    <h4>summary:</h4>
                    <p id="modal-short-description">Deskripsi singkat akan muncul di sini.</p>
                    <h4>Description:</h4>
                    <p id="modal-long-description">Deskripsi yang lebih panjang akan muncul di sini.</p>
                </div>
            </div>
        </div>
    </div>

    <script type="module" src="assets/js/main.js"></script>
  </body>
</html>
