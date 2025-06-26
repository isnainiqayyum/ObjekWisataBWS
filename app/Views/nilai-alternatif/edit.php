<!-- Menggunakan layout 'admin' sebagai template utama -->
<?= $this->extend('layouts/admin') ?>

<!-- Membuka blok konten utama -->
<?= $this->section('content') ?>

<!-- Container utama dengan margin atas dan teks terpusat -->
<div class="container mt-4 text-center font-lora">
    <!-- Judul halaman -->
    <h2 class="mb-4">Edit Nilai Alternatif</h2>

    <!-- Form untuk mengedit data nilai alternatif -->
    <!-- Aksi form mengarah ke route 'update' dengan ID nilai alternatif -->
    <form action="<?= site_url('admin/nilai-alternatif/update/' . $nilai['id']) ?>" method="post"
        class="d-inline-block text-start" style="max-width: 500px; width: 100%;">
        
        <!-- Tambahan CSRF protection untuk keamanan -->
        <?= csrf_field() ?>

        <!-- Dropdown untuk memilih wisata -->
        <div class="mb-3">
            <label for="wisata_id" class="form-label">Wisata</label>
            <select name="wisata_id" id="wisata_id" class="form-select" required>
                <option value="">-- Pilih Wisata --</option>
                <!-- Perulangan seluruh data wisata -->
                <?php foreach ($wisata as $w): ?>
                    <!-- Opsi yang akan dipilih otomatis jika id-nya sesuai dengan data yang sedang diedit -->
                    <option value="<?= $w['id'] ?>" <?= $w['id'] == $nilai['wisata_id'] ? 'selected' : '' ?>>
                        <?= esc($w['nama_wisata']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Dropdown untuk memilih sub kriteria -->
        <div class="mb-3">
            <label for="sub_kriteria_id" class="form-label">Sub Kriteria</label>
            <select name="sub_kriteria_id" id="sub_kriteria_id" class="form-select" required>
                <option value="">-- Pilih Sub Kriteria --</option>
                <!-- Perulangan seluruh sub kriteria -->
                <?php foreach ($subkriteria as $sk): ?>
                    <!-- Menandai opsi yang dipilih jika sesuai dengan data yang sedang diedit -->
                    <option value="<?= $sk['id'] ?>" <?= $sk['id'] == $nilai['sub_kriteria_id'] ? 'selected' : '' ?>>
                        <?= esc($sk['nama']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Input nilai untuk alternatif yang dipilih -->
        <div class="mb-3">
            <label for="nilai" class="form-label">Nilai</label>
            <!-- Input number, nilai awal diisi dari data nilai yang diedit -->
            <input type="number" step="0.01" name="nilai" id="nilai" class="form-control" value="<?= esc($nilai['nilai']) ?>" required>
        </div>

        <!-- Tombol aksi: update dan batal -->
        <div class="text-center mt-3">
            <button type="submit" class="btn btn-success">Update</button>
            <a href="<?= site_url('admin/nilai-alternatif') ?>" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

<!-- Menutup blok konten -->
<?= $this->endSection() ?>
