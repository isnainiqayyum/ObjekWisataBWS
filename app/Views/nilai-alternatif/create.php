<!-- Meng-extend layout admin utama -->
<?= $this->extend('layouts/admin') ?>

<!-- Membuka section konten -->
<?= $this->section('content') ?>

<!-- Container utama dengan margin top dan font kustom -->
<div class="container mt-4 text-center font-lora">
    <!-- Judul halaman -->
    <h2 class="mb-4">Tambah Nilai Alternatif</h2>

    <!-- Form untuk menambahkan data nilai alternatif -->
    <form action="<?= site_url('admin/nilai-alternatif/store') ?>" method="post" class="d-inline-block text-start" style="max-width: 500px; width: 100%;">
        <!-- CSRF field untuk keamanan form -->
        <?= csrf_field() ?>

        <!-- Dropdown pemilihan wisata -->
        <div class="mb-3">
            <label for="wisata_id" class="form-label">Wisata</label>
            <select name="wisata_id" id="wisata_id" class="form-select" required>
                <option value="">-- Pilih Wisata --</option>
                <!-- Loop semua data wisata dan tampilkan sebagai pilihan -->
                <?php foreach ($wisata as $w): ?>
                    <option value="<?= $w['id'] ?>"><?= esc($w['nama_wisata']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Dropdown pemilihan sub kriteria -->
        <div class="mb-3">
            <label for="sub_kriteria_id" class="form-label">Sub Kriteria</label>
            <select name="sub_kriteria_id" id="sub_kriteria_id" class="form-select" required>
                <option value="">-- Pilih Sub Kriteria --</option>
                <!-- Loop semua sub kriteria untuk ditampilkan -->
                <?php foreach ($subkriteria as $sk): ?>
                    <option value="<?= $sk['id'] ?>"><?= esc($sk['nama']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Input nilai yang diberikan untuk sub-kriteria pada wisata terpilih -->
        <div class="mb-3">
            <label for="nilai" class="form-label">Nilai</label>
            <input type="number" step="0.01" name="nilai" id="nilai" class="form-control" required>
        </div>

        <!-- Tombol aksi: simpan dan batal -->
        <div class="text-center mt-3">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="<?= site_url('admin/nilai-alternatif') ?>" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

<!-- Menutup section konten -->
<?= $this->endSection() ?>
