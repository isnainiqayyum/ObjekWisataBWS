<!DOCTYPE html> <!-- Mendefinisikan tipe dokumen HTML -->
<html lang="id"> <!-- Membuka elemen HTML dengan atribut bahasa Indonesia -->

<head>
    <meta charset="UTF-8" /> <!-- Menentukan encoding karakter ke UTF-8 -->
    <title>Detail Wisata</title> <!-- Judul halaman browser -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" /> <!-- Link ke file CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" /> <!-- Link ke icon Bootstrap -->
    <style>
        /* Gaya untuk kontainer agar lebar maksimal 1200px dan rata tengah */
        .container {
            max-width: 1200px;
            padding-left: 15px;
            padding-right: 15px;
            margin: auto;
        }

        /* Gaya untuk semua card agar seragam */
        .card-uniform {
            width: 100%;
            margin-bottom: 2rem;
            box-sizing: border-box;
        }

        /* Bagian latar belakang gambar dengan warna gradasi dan radius */
        .detail-wisata-img {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            padding: 15px;
            border-top-left-radius: 0.5rem;
            border-bottom-left-radius: 0.5rem;
            height: 100%;
        }

        /* Gaya gambar di detail wisata */
        .detail-wisata-img img {
            width: 100%;
            height: auto;
            object-fit: cover;
            display: block;
            border-radius: 0.5rem;
        }

        /* Judul wisata dengan warna hitam dan tebal */
        .detail-wisata-title {
            color: black !important;
            font-weight: 700;
        }

        /* Daftar fasilitas ditampilkan horizontal dan rapi */
        .fasilitas-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            padding-left: 0;
            list-style: none;
            margin: 0;
        }

        /* Gaya item fasilitas */
        .fasilitas-list li {
            background-color: rgb(58, 175, 248);
            color: white;
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 0.9rem;
            white-space: nowrap;
        }

        /* Blok rating dengan warna latar khusus dan bayangan */
        .rating-highlight {
            background-color: #fff3cd;
            border: 1px solid #ffeeba;
            padding: 15px;
            border-radius: 0.5rem;
            box-shadow: 0 0 10px rgba(255, 193, 7, 0.5);
            margin-top: 1rem;
        }

        /* Gaya label bintang rating */
        .star-label {
            cursor: pointer;
            color: gray;
            transition: transform 0.2s ease, color 0.2s ease;
        }

        /* Bintang yang dipilih atau disorot */
        .star-label.selected,
        .star-label.hovered {
            color: gold;
            transform: scale(1.3);
        }
    </style>
</head>

<body class="bg-light"> <!-- Warna latar belakang halaman -->
    <div class="container py-5"> <!-- Kontainer utama dengan padding vertikal -->

        <!-- Tombol kembali dengan icon -->
        <div style="margin-bottom:1.5rem; text-align:center;">
            <a href="<?= site_url('/') ?>" title="Kembali" aria-label="Kembali" style="font-size:1.5rem; color:#0d6efd; text-decoration:none;">
                <i class="bi bi-arrow-left-circle-fill"></i> <!-- Icon panah kembali -->
            </a>
        </div>

        <!-- DETAIL WISATA -->
        <div class="card shadow-sm rounded card-uniform"> <!-- Kartu detail wisata -->
            <div class="row g-0 align-items-stretch">
                <div class="col-md-6"> <!-- Kolom kiri: gambar -->
                    <div class="h-100 w-100 overflow-hidden">
                        <img src="<?= base_url('assets/images/' . $wisata['gambar']) ?>" alt="<?= esc($wisata['nama_wisata']) ?>" class="img-fluid h-100 w-100" style="object-fit: cover; border-top-left-radius: 0.5rem; border-bottom-left-radius: 0.5rem;" />
                    </div>
                </div>
                <div class="col-md-6 d-flex flex-column justify-content-between p-4"> <!-- Kolom kanan: detail teks -->
                    <h2 class="card-title detail-wisata-title mb-4"><?= esc($wisata['nama_wisata']) ?></h2>
                    <p class="lead text-secondary mb-4"><?= esc($wisata['deskripsi']) ?></p>

                    <div class="row g-3 mb-3"> <!-- Info wisata -->
                        <div class="col-12 d-flex align-items-start">
                            <i class="bi bi-geo-alt-fill text-primary me-2 fs-5"></i> <!-- Icon lokasi -->
                            <div>
                                <strong>Alamat:</strong><br />
                                <a href="<?= esc($wisata['alamat']) ?>" target="_blank" class="text-decoration-none">
                                    <i class="bi bi-geo-alt-fill text-danger me-1"></i> Lihat di Google Maps
                                </a>
                            </div>
                        </div>
                        <!-- Info jenis wisata -->
                        <div class="col-12 d-flex align-items-start">
                            <i class="bi bi-tags-fill text-success me-2 fs-5"></i>
                            <div><strong>Jenis Wisata:</strong><br /><?= isset($jenisWisata) ? esc($jenisWisata['nama']) : '-' ?></div>
                        </div>
                        <!-- Info harga -->
                        <div class="col-12 d-flex align-items-start">
                            <i class="bi bi-cash-coin text-warning me-2 fs-5"></i>
                            <div><strong>Harga Tiket:</strong><br /><?= esc($wisata['harga_tiket']) ?></div>
                        </div>
                        <!-- Info akses -->
                        <div class="col-12 d-flex align-items-start">
                            <i class="bi bi-bus-front-fill text-info me-2 fs-5"></i>
                            <div><strong>Akses:</strong><br /><?= esc($wisata['akses']) ?></div>
                        </div>
                        <!-- Info jam buka -->
                        <div class="col-12 d-flex align-items-start">
                            <i class="bi bi-clock-fill text-danger me-2 fs-5"></i>
                            <div><strong>Jam Operasional:</strong><br /><?= esc($wisata['jam_operasional']) ?></div>
                        </div>
                        <!-- Info fasilitas -->
                        <div class="col-12 d-flex align-items-start">
                            <i class="bi bi-tools text-secondary me-2 fs-5"></i>
                            <div>
                                <strong>Fasilitas:</strong><br />
                                <?php if (!empty($wisata['fasilitas'])): ?>
                                    <ul class="fasilitas-list">
                                        <?php foreach (explode(',', $wisata['fasilitas']) as $f): ?>
                                            <li><?= esc(trim($f)) ?></li> <!-- Setiap fasilitas jadi item -->
                                        <?php endforeach; ?>
                                    </ul>
                                <?php else: ?>
                                    <span class="text-muted">Tidak tersedia</span> <!-- Jika kosong -->
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Rating Wisata -->
                    <div class="rating-highlight">
                        <h5 class="mb-1">Rating Wisata:</h5>
                        <span class="fs-4 text-warning">
                            <?= $rating ? str_repeat('⭐', round($rating->avg_rating)) : '⭐⭐⭐⭐⭐' ?>
                        </span>
                        <span class="ms-2">
                            (<?= $rating ? round($rating->avg_rating, 1) : '0.0' ?> dari <?= $rating ? $rating->total_ulasan : '0' ?> ulasan)
                        </span>
                        <div class="mt-1 text-muted">
                            Ulasan: <strong><?= $rating ? $rating->total_ulasan : '0' ?></strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FORM ULASAN -->
        <div id="form-ulasan" class="card shadow-sm card-uniform">
            <div class="card-body">
                <h4 class="card-title mb-3">Tinggalkan Ulasan Anda</h4>

                <!-- Menampilkan pesan sukses -->
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                    </div>
                <?php endif; ?>

                <!-- Menampilkan pesan error -->
                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                    </div>
                <?php endif; ?>

                <!-- Form kirim ulasan -->
                <form method="post" action="<?= base_url('ulasan/simpan') ?>">
                    <?= csrf_field() ?> <!-- Proteksi CSRF -->
                    <input type="hidden" name="wisata_id" value="<?= $wisata['id'] ?>" /> <!-- ID wisata -->

                    <!-- Input rating -->
                    <div class="mb-3">
                        <label class="form-label d-block">Rating Anda:</label>
                        <div id="rating-stars" class="d-flex gap-2 fs-2">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <input type="radio" name="rating" value="<?= $i ?>" id="star<?= $i ?>" class="d-none"
                                    <?= old('rating') == $i ? 'checked' : '' ?> required />
                                <label for="star<?= $i ?>" class="star-label <?= old('rating') >= $i ? 'selected' : '' ?>" data-star="<?= $i ?>">⭐</label>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <!-- Input komentar -->
                    <div class="mb-3">
                        <label class="form-label">Komentar:</label>
                        <textarea name="komentar" class="form-control shadow-sm" rows="3"
                            placeholder="Bagikan pengalaman Anda..." required><?= old('komentar') ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary px-4">Kirim Ulasan</button> <!-- Tombol kirim -->
                </form>
            </div>
        </div>

        <!-- ULASAN PENGUNJUNG -->
        <div class="card shadow-sm card-uniform">
            <div class="card-body">
                <h4 class="card-title mb-4">Ulasan Pengunjung</h4>
                <?php if (count($ulasan) > 0): ?>
                    <?php foreach ($ulasan as $u): ?>
                        <div class="border-start border-4 border-primary bg-white p-3 mb-3 shadow-sm rounded">
                            <div class="d-flex justify-content-between">
                                <div><strong class="text-warning"><?= str_repeat('⭐', $u['rating']) ?></strong></div>
                                <small class="text-muted"><?= date('d M Y, H:i', strtotime($u['created_at'])) ?></small>
                            </div>
                            <p class="mt-2 mb-1"><?= esc($u['komentar']) ?></p> <!-- Teks komentar -->
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted fst-italic">Belum ada ulasan. Jadilah yang pertama!</p> <!-- Jika belum ada ulasan -->
                <?php endif; ?>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const labels = document.querySelectorAll('.star-label'); // Ambil semua label bintang
            let selectedRating = parseInt(document.querySelector('input[name="rating"]:checked')?.value) || 0;

            labels.forEach(label => {
                const starValue = parseInt(label.dataset.star);

                label.addEventListener('click', () => {
                    selectedRating = starValue;
                    updateStars(); // Update tampilan bintang saat klik
                });

                label.addEventListener('mouseover', () => updateStars(starValue)); // Saat hover
                label.addEventListener('mouseout', () => updateStars()); // Saat keluar hover

                if (selectedRating && starValue <= selectedRating) {
                    label.classList.add('selected'); // Tandai bintang yang dipilih
                }
            });

            function updateStars(hover = 0) {
                labels.forEach(label => {
                    const star = parseInt(label.dataset.star);
                    label.classList.remove('selected', 'hovered');
                    if (hover) {
                        if (star <= hover) label.classList.add('hovered');
                    } else {
                        if (star <= selectedRating) label.classList.add('selected');
                    }
                });
            }

            // Auto-scroll ke form jika ada flashdata
            <?php if (session()->getFlashdata('success') || session()->getFlashdata('errors')): ?>
                const formUlasan = document.getElementById('form-ulasan');
                if (formUlasan) {
                    formUlasan.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            <?php endif; ?>

            // Alert hilang otomatis setelah 5 detik
            setTimeout(() => {
                document.querySelectorAll('.alert').forEach(el => el.classList.remove('show'));
            }, 5000);
        });
    </script>

    <!-- Script Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
