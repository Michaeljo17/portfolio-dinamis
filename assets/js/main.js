// File: assets/js/main.js

// Menjalankan semua skrip setelah seluruh dokumen HTML dan sumber dayanya (seperti gambar) selesai dimuat.
// Ini penting agar semua elemen, termasuk yang dari PHP, sudah ada saat JS berjalan.
document.addEventListener('DOMContentLoaded', () => {

    // --- KODE EFEK VISUAL (CURSOR & BLOB) ---
    const cursor = document.querySelector('.cursor');
    const blob = document.getElementById('blob');

    if (blob && cursor) {
        document.body.onpointermove = event => {
            const { clientX, clientY } = event;
            
            // Gerakkan kursor kustom
            cursor.style.left = `${clientX}px`;
            cursor.style.top = `${clientY}px`;
            
            // Gerakkan aurora blob dengan animasi halus
            blob.animate({
                left: `${clientX}px`,
                top: `${clientY}px`
            }, { duration: 3000, fill: "forwards" });
        };
    }

    // --- KODE NAVIGASI SMOOTH SCROLL ---
    const navLinks = document.querySelectorAll('header nav a[href^="#"]');
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const id = this.getAttribute('href');
            const targetElement = document.querySelector(id);
            if (targetElement) {
                targetElement.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });

    // --- KODE FITUR EXPAND/COLLAPSE PROYEK ---
    const detailLinks = document.querySelectorAll('.project-card a');
    detailLinks.forEach(link => {
        // Hanya tambahkan event listener ini pada link "Lihat Detail"
        // yang tidak memiliki target="_blank" dan href-nya adalah "#"
        if (link.getAttribute('href') === '#') {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const card = this.closest('.project-card');
                if (card) {
                    card.classList.toggle('expanded');
                    if (card.classList.contains('expanded')) {
                        this.innerHTML = 'Tutup &uarr;'; // Ganti teks menjadi "Tutup"
                    } else {
                        this.innerHTML = 'Lihat Detail &rarr;'; // Kembalikan teks ke semula
                    }
                }
            });
        }
    });

});