<?= $this->extend('layouts/admin') ?> 
<!-- Memperluas layout dari file layouts/admin agar halaman ini mengikuti template admin -->

<?= $this->section('content') ?> 
<!-- Membuka section 'content' yang akan dimasukkan ke dalam layout -->

<div class="card shadow rounded p-4 mx-auto" style="max-width: 720px;">
<!-- Membuat container card Bootstrap dengan padding, bayangan, dan ukuran maksimum -->

    <h2 class="mb-4">Tambah Sub Kriteria</h2>
    <!-- Judul halaman -->

    <form action="<?= route_to('admin/sub-kriteria/store') ?>" method="post">
    <!-- Form untuk menambah sub kriteria, akan dikirim ke route 'admin/sub-kriteria/store' dengan metode POST -->

        <?= csrf_field() ?>
        <!-- Menyisipkan token CSRF untuk keamanan agar mencegah serangan CSRF -->

        <!-- Nama Sub Kriteria -->
        <div class="mb-3">
            <label for="nama" class="form-label text-muted small">Nama Sub Kriteria</label>
            <!-- Label untuk input nama sub kriteria -->
            <input type="text"
                class="form-control form-control-sm border border-secondary-subtle px-3 py-2 shadow-sm"
                name="nama"
                id="nama"
                value="<?= old('nama') ?>"
                required>
            <!-- Input text untuk nama sub kriteria, menggunakan nilai lama jika ada (old input), dan wajib diisi -->
        </div>

        <!-- Kriteria -->
        <div class="mb-3">
            <label for="kriteria_id" class="form-label text-muted small">Kriteria</label>
            <!-- Label untuk dropdown pilihan kriteria -->
            <select name="kriteria_id"
                id="kriteria_id"
                class="form-select form-select-sm border border-secondary-subtle px-3 py-2 shadow-sm"
                required>
                <!-- Dropdown untuk memilih kriteria, wajib diisi -->
                <option disabled selected>-- Pilih Kriteria --</option>
                <!-- Placeholder default di dropdown -->
                <?php foreach ($kriteria as $k): ?>
                    <!-- Melakukan iterasi array $kriteria untuk menampilkan semua opsi -->
                    <option value="<?= $k['id'] ?>" <?= old('kriteria_id') == $k['id'] ? 'selected' : '' ?>>
                        <?= esc($k['nama_kriteria']) ?>
                    </option>
                    <!-- Menampilkan nama kriteria dan menandai sebagai terpilih jika sesuai dengan input sebelumnya -->
                <?php endforeach ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary px-4 py-2">Simpan</button>
        <!-- Tombol untuk mengirimkan form -->
    </form>
</div>

<?= $this->endSection() ?> 
<!-- Menutup section 'content' -->
