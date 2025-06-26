<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Hasil Rekomendasi Wisata</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Google Fonts untuk font Open Sans dan Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Poppins:wght@600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS dari CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        /* Gaya dasar body */
        body {
            font-family: 'Open Sans', sans-serif;
            background: #f4f4f4;
            padding: 50px 0;
        }

        /* Container utama */
        .container {
            max-width: 960px;
            margin: auto;
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08);
        }

        /* Judul halaman */
        h2 {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 1.9rem;
            text-align: center;
            color: #2563eb;
            margin-bottom: 40px;
        }

        /* Kartu wisata dengan efek hover */
        .card-hover {
            background-color: rgb(235, 238, 240);
            border-radius: 10px;
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease-in-out;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        /* Efek hover pada kartu */
        .card-hover:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
        }

        /* Gambar pada kartu */
        .card-img-top {
            height: 200px;
            object-fit: cover;
            border-radius: 10px 10px 0 0;
            flex-shrink: 0;
        }

        /* Konten kartu */
        .card-body {
            padding: 20px 24px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            position: relative;
        }

        /* Judul wisata di kartu */
        .card-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            color: #000;
            font-size: 1.1rem;
            margin-bottom: 15px;
            white-space: normal;
            overflow-wrap: break-word;
            flex-grow: 0;
            text-align: center;
        }

        /* Baris bawah kartu: peringkat dan tombol detail */
        .bottom-row {
            margin-top: auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-shrink: 0;
        }

        /* Gaya teks peringkat */
        .rank {
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: 700;
            color: #000;
            font-size: 1.1rem;
            white-space: nowrap;
        }

        /* Ikon piala pada peringkat */
        .rank i {
            font-size: 1.4rem;
        }

        /* Lencana skor dengan latar biru */
        .score-badge {
            font-size: 0.85rem;
            background-color: #2563eb;
            color: #fff;
            padding: 3px 8px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        /* Tombol detail pada setiap kartu */
        .btn-detail {
            background: #2563eb;
            border: none;
            color: white;
            font-weight: 600;
            border-radius: 50px;
            padding: 8px 20px;
            transition: 0.3s;
            cursor: pointer;
        }

        /* Efek hover tombol detail */
        .btn-detail:hover {
            background-color: #3b82f6;
            transform: translateY(-2px);
        }

        /* Alert jika tidak ada data */
        .alert-warning {
            background-color: #fef3c7;
            border-radius: 12px;
            font-weight: 600;
            color: #92400e;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(245, 158, 11, 0.25);
        }

        /* Tombol kembali */
        .btn-back {
            margin-top: 30px;
            display: inline-block;
            padding: 12px 30px;
            border-radius: 50px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-back:hover {
            background-color: #3b82f6;
        }

        /* Responsive padding untuk layar kecil */
        @media (max-width: 576px) {
            .container {
                padding: 25px 20px;
            }

            /* Menyesuaikan tinggi gambar agar tidak memakan banyak tempat */
            .card-img-top {
                height: 160px;
            }

            /* Ukuran font dikurangi di layar kecil */
            .card-title {
                font-size: 1rem;
            }

            .rank {
                font-size: 1rem;
            }

            .btn-detail {
                padding: 6px 16px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Hasil Rekomendasi Wisata</h2>

        <!-- Jika ada hasil rekomendasi -->
        <?php if (!empty($result)): ?>
            <div class="row g-4">
                <?php $rank = 1; ?>
                <?php foreach ($result as $row): ?>
                    <div class="col-12 col-md-6 col-lg-4 d-flex">
                        <div class="card-hover">
                            <div class="position-relative">
                                <!-- Cek apakah ada gambar, jika tidak tampilkan placeholder -->
                                <?php if (!empty($row['wisata']['gambar'])): ?>
                                    <img src="<?= esc('assets/images/' . $row['wisata']['gambar']) ?>" class="card-img-top" alt="<?= esc($row['wisata']['nama_wisata']) ?>" />
                                <?php else: ?>
                                    <img src="https://via.placeholder.com/400x200?text=No+Image" class="card-img-top" alt="No Image" />
                                <?php endif; ?>

                                <!-- Tampilkan skor di pojok kanan atas -->
                                <span class="position-absolute top-0 end-0 m-2 badge score-badge">
                                    <i class="bi bi-star-fill"></i> <?= number_format($row['score'], 4) ?>
                                </span>
                            </div>

                            <!-- Bagian konten kartu -->
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?= esc($row['wisata']['nama_wisata']) ?></h5>

                                <!-- Bagian bawah kartu berisi peringkat dan tombol detail -->
                                <div class="bottom-row">
                                    <div class="rank">
                                        <i class="bi bi-trophy-fill"></i> Peringkat <?= $rank++ ?>
                                    </div>

                                    <!-- Tombol untuk menuju halaman detail -->
                                    <a href="<?= site_url('wisata/' . $row['wisata']['id']) ?>" class="btn btn-detail">
                                        Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        <!-- Jika tidak ada hasil rekomendasi -->
        <?php else: ?>
            <div class="alert alert-warning mt-4">
                Tidak ada wisata yang cocok dengan filter yang dipilih.
            </div>
        <?php endif; ?>

        <!-- Tombol kembali ke form filter -->
        <div class="text-center">
            <a href="<?= site_url('rekomendasi/filter-form') ?>" class="btn-back">Kembali ke Filter</a>
        </div>
    </div>

    <!-- Bootstrap JS bundle untuk interaktivitas -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
