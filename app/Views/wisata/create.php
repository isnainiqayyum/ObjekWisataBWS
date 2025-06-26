<?= $this->extend('layouts/admin') ?> // Meng-extend layout 'admin' sebagai template utama

<?= $this->section('content') ?> // Membuka section 'content' untuk mengisi konten halaman

<div class="card shadow rounded p-4 mx-auto" style="max-width: 720px;"> // Container card dengan padding dan lebar maksimum

    <h2 class="mb-4">Tambah Wisata</h2> // Judul form

    <form action="/admin/wisata/store" method="post" enctype="multipart/form-data"> // Form dengan method POST dan support upload file
        <?php if (session('errors')): ?> // Cek apakah ada pesan error dalam session
            <div class="alert alert-danger"> // Tampilkan pesan error jika ada
                <ul class="mb-0">
                    <?php foreach (session('errors') as $error): ?> // Loop setiap error yang ada
                        <li><?= esc($error) ?></li> // Tampilkan error secara aman
                    <?php endforeach ?>
                </ul>
            </div>
        <?php endif; ?>

        <?= csrf_field() ?> // Token CSRF untuk mencegah serangan CSRF

        <!-- Nama Wisata -->
        <div class="mb-3">
            <label for="nama_wisata" class="form-label text-muted small">Nama Wisata</label> // Label input nama wisata
            <input type="text"
                class="form-control form-control-sm border border-secondary-subtle px-3 py-2 shadow-sm" // Input teks dengan styling Bootstrap
                id="nama_wisata"
                name="nama_wisata"
                value="<?= old('nama_wisata') ?>" // Menyimpan nilai input sebelumnya jika form gagal dikirim
                required> // Wajib diisi
        </div>

        <!-- Alamat -->
        <div class="mb-3">
            <label for="alamat" class="form-label text-muted small">Alamat</label> // Label input alamat
            <input type="text"
                class="form-control form-control-sm border border-secondary-subtle px-3 py-2 shadow-sm" // Input teks untuk alamat
                id="alamat"
                name="alamat"
                value="<?= old('alamat') ?>" // Menyimpan input sebelumnya
                required> // Wajib diisi
        </div>

        <!-- Gambar Wisata -->
        <div class="mb-3">
            <label for="gambar" class="form-label text-muted small">Gambar Wisata</label> // Label input file gambar
            <input type="file"
                class="form-control form-control-sm border border-secondary-subtle px-3 py-2 shadow-sm" // Input file untuk upload gambar
                id="gambar"
                name="gambar"
                accept="image/*" // Hanya menerima file gambar
                required> // Wajib diisi
        </div>

        <!-- Sub Kriteria -->
        <div class="mb-3">
            <label for="sub_kriteria_id" class="form-label text-muted small">Sub Kriteria</label> // Label dropdown sub kriteria
            <select
                class="form-select form-select-sm border border-secondary-subtle px-3 py-2 shadow-sm" // Dropdown dengan styling
                id="sub_kriteria_id"
                name="sub_kriteria_id"
                required> // Wajib dipilih
                <option disabled selected>-- Pilih Sub Kriteria --</option> // Placeholder pertama
                <?php foreach ($subkriteria as $sk): ?> // Loop data subkriteria dari controller
                    <option value="<?= $sk['id'] ?>" <?= old('sub_kriteria_id') == $sk['id'] ? 'selected' : '' ?>> // Tandai terpilih jika sebelumnya diinput
                        <?= esc($sk['nama']) ?> // Tampilkan nama subkriteria
                    </option>
                <?php endforeach ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary px-4 py-2">Simpan</button> // Tombol submit untuk menyimpan data
    </form>
</div>

<?= $this->endSection() ?> // Menutup section 'content'
