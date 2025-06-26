<!DOCTYPE html> <!-- Mendefinisikan bahwa dokumen ini adalah HTML5 -->
<html lang="id"> <!-- Awal dokumen HTML dengan atribut bahasa Indonesia -->

<head> <!-- Bagian kepala dari dokumen HTML -->
    <meta charset="UTF-8"> <!-- Mengatur karakter encoding ke UTF-8 -->
    <title>Landing Page Wisata Bondowoso</title> <!-- Judul tab browser -->
    <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Agar tampilan responsive di perangkat mobile -->

    <!-- Bootstrap Icons dari CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Bootstrap CSS dari CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts (Roboto) -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto', sans-serif; /* Menggunakan font Roboto */
            scroll-behavior: smooth; /* Scroll antar section jadi smooth */
        }

        .card-hover:hover {
            transform: translateY(-4px); /* Efek hover: naik 4px */
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15); /* Bayangan pada hover */
            transition: 0.3s ease; /* Transisi halus */
        }

        .transition {
            transition: all 0.3s ease-in-out; /* Transisi umum */
        }

        .hero {
            /* Latar belakang dengan gradasi gelap dan gambar background */
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
                url("<?= base_url('assets/images/background.jpg') ?>") center/cover no-repeat;
            height: 70vh; /* Tinggi 70% dari tinggi viewport */
            color: white; /* Warna teks putih */
            display: flex; /* Menggunakan flexbox */
            align-items: center; /* Pusat secara vertikal */
            justify-content: center; /* Pusat secara horizontal */
            flex-direction: column; /* Susun elemen secara vertikal */
            text-align: center; /* Rata tengah teks */
            text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.6); /* Bayangan teks */
        }

        .card-img-top {
            height: 200px; /* Tinggi gambar dalam kartu */
            object-fit: cover; /* Gambar menyesuaikan dan tidak terdistorsi */
        }

        footer {
            background-color: #f8f9fa; /* Warna latar belakang footer */
            padding: 1.5rem 0; /* Padding atas bawah 1.5rem */
        }

        .card-title {
            font-size: 1.1rem; /* Ukuran font judul kartu */
            font-weight: bold; /* Tebal */
        }

        .btn-detail {
            margin-top: 10px; /* Jarak atas tombol */
        }

        .section-heading {
            font-weight: bold; /* Tebal */
            font-size: 1.8rem; /* Ukuran font besar */
            margin-bottom: 2rem; /* Jarak bawah 2rem */
        }

        .nav-link:hover {
            color: #ffd700 !important; /* Warna teks kuning saat hover navbar */
        }

        .bg-soft-blue {
            background-color: #e6f2ff; /* Warna latar belakang biru muda */
        }

        .object-fit-cover {
            object-fit: cover; /* Gambar penuh area tanpa distorsi */
        }

        .text-justify {
            text-align: justify; /* Paragraf rata kiri kanan */
        }
    </style>
</head>

<body> <!-- Awal dari konten body -->

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top"
        style="background-color: rgba(24, 23, 23, 0.8); backdrop-filter: blur(12px); z-index: 1030;">
        <!-- Navbar dengan warna semi-transparan dan blur -->
        <div class="container"> <!-- Container bootstrap -->
            <a class="navbar-brand" href="#beranda"> <!-- Logo mengarah ke #beranda -->
                <img src="assets/images/logo.png" alt="Logo" height="40"> <!-- Gambar logo -->
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span> <!-- Ikon hamburger untuk mobile -->
            </button>

            <div class="collapse navbar-collapse" id="navbarContent"> <!-- Isi navbar yang bisa collapse -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0"> <!-- Daftar navigasi -->
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#beranda">Beranda</a> <!-- Link ke section Beranda -->
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#destinasi">Destinasi</a> <!-- Link ke section Destinasi -->
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tentang">Tentang</a> <!-- Link ke section Tentang -->
                    </li>
                </ul>
                <a href="<?= base_url('login') ?>" class="btn btn-outline-light">Login</a> <!-- Tombol login -->
            </div>
        </div>
    </nav>

    <!-- HERO SECTION (Beranda) -->
    <section id="beranda" class="hero"> <!-- Bagian beranda -->
        <div class="container">
            <h1 class="display-4">Selamat Datang di Wisata Bondowoso</h1> <!-- Judul utama -->
            <p class="lead">Jelajahi keindahan dan keunikan destinasi wisata lokal</p> <!-- Subjudul -->
            <a href="<?= base_url('rekomendasi/filter-form') ?>" class="btn btn-primary btn-lg mt-4 shadow-sm"
                style="font-weight: 700; background-color: #6c9ef8; border-color: #6c9ef8;">
                Lihat Rekomendasi <!-- Tombol lihat rekomendasi -->
            </a>
        </div>
    </section>

    <!-- DESTINASI SECTION -->
    <section id="destinasi" class="container py-5"> <!-- Section destinasi -->
        <h2 class="text-center section-heading">Destinasi Populer</h2> <!-- Judul section -->
        <div class="row">
            <?php foreach ($wisata as $w): ?> <!-- Looping data wisata -->
                <div class="col-md-4 mb-4"> <!-- Kolom untuk setiap kartu -->
                    <div class="card h-100 shadow-sm border-0 rounded-2 overflow-hidden card-hover bg-light">
                        <div class="position-relative">
                            <img src="<?= base_url('assets/images/' . $w['gambar']) ?>" class="card-img-top" alt="<?= esc($w['nama_wisata']) ?>" style="height: 220px; object-fit: cover;">
                            <!-- Gambar destinasi -->
                            <span class="position-absolute top-0 end-0 m-2 badge bg-primary px-3 py-2 rounded-pill d-flex align-items-center gap-1" style="font-size: 0.85rem;">
                                💰 Rp <?= number_format($w['harga_tiket'], 0, ',', '.') ?> <!-- Harga tiket -->
                            </span>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-semibold text-dark text-center"><?= esc($w['nama_wisata']) ?></h5> <!-- Nama wisata -->
                            <p class="card-text text-muted flex-grow-1 text-justify" style="font-size: 0.93rem;">
                                <?= esc(strlen($w['deskripsi']) > 100 ? substr(strip_tags($w['deskripsi']), 0, 100) . '...' : strip_tags($w['deskripsi'])) ?>
                                <!-- Potongan deskripsi maksimal 100 karakter -->
                            </p>
                            <a href="<?= base_url('wisata/' . $w['id']) ?>" class="btn btn-outline-primary btn-sm mt-auto rounded-pill">
                                Lihat Detail <!-- Tombol lihat detail -->
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?> <!-- Akhir looping -->
        </div>
    </section>

    <!-- TENTANG SECTION -->
    <section id="tentang" class="bg-soft-blue py-5"> <!-- Section tentang -->
        <div class="container">
            <h2 class="text-center section-heading mb-5">Tentang Wisata Bondowoso</h2> <!-- Judul section -->
            <div class="card shadow-sm border-0">
                <div class="row g-0">
                    <!-- Bagian Kiri: Deskripsi -->
                    <div class="col-md-6 p-4 d-flex flex-column justify-content-center">
                        <h4 class="fw-bold mb-3">Mengenal Lebih Dekat</h4> <!-- Subjudul -->
                        <p class="mb-3 text-justify">
                            BonDay adalah sistem rekomendasi wisata cerdas yang dirancang khusus untuk mengeksplorasi destinasi unggulan di Kabupaten Bondowoso. Fokus kami adalah menghadirkan pilihan wisata alam, buatan, sejarah, dan budaya yang sesuai dengan minat dan preferensi pengunjung.
                        </p>
                        <p class="text-justify">
                            Dengan dukungan teknologi dan informasi yang akurat, BonDay membantu wisatawan menemukan pengalaman terbaik di setiap sudut Bondowoso dari keindahan alam yang memukau hingga kekayaan budaya yang autentik.
                        </p>
                    </div>

                    <!-- Bagian Kanan: Gambar -->
                    <div class="col-md-6">
                        <img src="<?= base_url('assets/images/gerbong_maut1.jpg') ?>" alt="Tentang Wisata Bondowoso"
                            class="img-fluid rounded-end h-100 w-100 object-fit-cover"> <!-- Gambar bagian tentang -->
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="text-center"> <!-- Footer bawah halaman -->
        <div class="container">
            <p class="mb-0">&copy; <?= date('Y') ?> Wisata Bondowoso. Semua hak dilindungi.</p> <!-- Hak cipta -->
        </div>
    </footer>

    <!-- Bootstrap JS dari CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html> <!-- Akhir dokumen HTML -->
