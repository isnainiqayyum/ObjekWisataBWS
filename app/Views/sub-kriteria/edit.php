<?= $this->extend('layouts/admin') ?> 
<!-- Memperluas layout dari file layouts/admin agar tampilan mengikuti template admin -->

<?= $this->section('content') ?> 
<!-- Membuka section 'content' yang akan dimasukkan ke dalam layout utama -->

<div class="card shadow rounded p-4 mx-auto mt-4" style="max-width: 720px;">
<!-- Membuat container card dengan padding, bayangan, border rounded, dan lebar maksimum 720px -->

    <h2 class="mb-4">Edit Sub Kriteria</h2>
    <!-- Judul halaman untuk mengedit sub kriteria -->

    <!-- <form action="<?= route_to('admin/sub-kriteria/update', $subkriteria['id']) ?>" method="post"> -->
    <!-- Baris di atas dikomentari, sebelumnya digunakan untuk generate URL dengan route_to() -->
    
    <form action="/admin/sub-kriteria/update/<?= $subkriteria['id'] ?>" method="post">
    <!-- Form dikirim menggunakan metode POST ke URL dengan ID sub kriteria untuk update -->

        <?= csrf_field() ?>
        <!-- Token keamanan CSRF untuk mencegah serangan Cross Site Request Forgery -->

        <!-- Nama Sub Kriteria -->
        <div class="mb-3">
            <label for="nama" class="form-label text-muted small">Nama Sub Kriteria</label>
            <!-- Label untuk input nama sub kriteria -->
            <input type="text"
                class="form-control form-control-sm border border-secondary-subtle px-3 py-2 shadow-sm"
                id="nama"
                name="nama"
                value="<?= old('nama', esc($subkriteria['nama'])) ?>"
                required>
            <!-- Input text berisi nilai lama dari input sebelumnya jika ada (old), jika tidak maka menampilkan data dari $subkriteria -->
        </div>

        <!-- Kriteria -->
        <div class="mb-3">
            <label for="kriteria_id" class="form-label text-muted small">Kriteria</label>
            <!-- Label untuk dropdown kriteria -->
            <select
                class="form-select form-select-sm border border-secondary-subtle px-3 py-2 shadow-sm"
                id="kriteria_id"
                name="kriteria_id"
                required>
                <!-- Select dropdown untuk memilih kriteria yang sesuai -->
                <option disabled>-- Pilih Kriteria --</option>
                <!-- Placeholder untuk pilihan kriteria -->
                <?php foreach ($kriteria as $k): ?>
                    <!-- Melakukan iterasi array $kriteria -->
                    <option value="<?= $k['id'] ?>" <?= (old('kriteria_id', $subkriteria['kriteria_id']) == $k['id']) ? 'selected' : '' ?>>
                        <?= esc($k['nama_kriteria']) ?>
                    </option>
                    <!-- Opsi kriteria ditampilkan, jika sesuai dengan nilai lama atau data lama maka akan otomatis terpilih -->
                <?php endforeach ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary px-4 py-2">Update</button>
        <!-- Tombol untuk mengirim form update -->
    </form>
</div>

<?= $this->endSection() ?>
<!-- Menutup section 'content' -->
