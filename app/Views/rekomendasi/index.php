<!DOCTYPE html>
<html lang="id">

<head>
    <!-- Pengaturan karakter dan judul halaman -->
    <meta charset="UTF-8" />
    <title>Filter Rekomendasi</title>

    <!-- Responsive viewport agar tampilan mobile-friendly -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap CSS untuk styling cepat dan responsif -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <style>
        /* Gaya untuk keseluruhan halaman */
        body {
            background: #e0e7ff; /* Latar belakang biru muda */
            font-family: 'Segoe UI', sans-serif; /* Font utama */
        }

        /* Gaya untuk form section */
        .form-section {
            background: #ffffff; /* Latar belakang putih */
            border-radius: 12px; /* Sudut membulat */
            padding: 2rem; /* Padding dalam kotak */
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); /* Bayangan lembut */
        }
    </style>
</head>

<!-- Tambahan padding vertikal untuk spasi di bagian atas dan bawah -->
<body class="py-5">
    <div class="container">
        <!-- Tombol kembali ke halaman landing -->
        <div class="mb-4">
            <a href="<?= site_url('/') ?>" class="btn btn-outline-primary">&larr; Kembali ke Landing</a>
        </div>

        <!-- Seksi utama berisi form filter -->
        <div class="form-section">
            <h2 class="mb-4 text-center">Filter Rekomendasi Wisata</h2>

            <!-- Tampilkan pesan error jika ada -->
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <!-- Form filter, dikirim ke route 'rekomendasi' menggunakan metode POST -->
            <form action="<?= site_url('rekomendasi') ?>" method="post">
                <?= csrf_field() ?> <!-- Proteksi CSRF untuk keamanan form -->

                <div class="row">
                    <div class="col-12">
                        <h5>Filter Berdasarkan Sub-Kriteria</h5>

                        <!-- Loop setiap sub-kriteria dan tampilkan input yang sesuai -->
                        <?php foreach ($subKriteria as $namaKriteria => $items): ?>
                            <div class="mb-4">
                                <!-- Label nama kriteria -->
                                <label class="form-label"><?= esc($namaKriteria) ?></label>

                                <!-- Jika kriterianya 'Fasilitas' atau 'Akses', tampilkan sebagai checkbox -->
                                <?php if (in_array($namaKriteria, ['Fasilitas', 'Akses'])): ?>
                                    <div class="d-flex flex-wrap gap-2">
                                        <?php foreach ($items as $item): ?>
                                            <div class="form-check me-3">
                                                <!-- Checkbox input -->
                                                <input class="form-check-input" type="checkbox"
                                                    name="sub_kriteria[<?= esc($namaKriteria) ?>][]"
                                                    id="<?= esc($namaKriteria) . '_' . $item['id'] ?>"
                                                    value="<?= $item['id'] ?>">
                                                <!-- Label untuk checkbox -->
                                                <label class="form-check-label"
                                                    for="<?= esc($namaKriteria) . '_' . $item['id'] ?>">
                                                    <?= esc($item['nama']) ?>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else: ?>
                                    <!-- Jika bukan Fasilitas/Akses, tampilkan sebagai dropdown select -->
                                    <select name="sub_kriteria[<?= esc($namaKriteria) ?>]" class="form-select">
                                        <option value="">Pilih <?= esc($namaKriteria) ?></option>
                                        <?php foreach ($items as $item): ?>
                                            <option value="<?= $item['id'] ?>"><?= esc($item['nama']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Tombol submit form -->
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary px-5">Cari Rekomendasi</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
