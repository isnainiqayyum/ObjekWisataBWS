<?= $this->extend('layouts/admin') ?> // Menggunakan layout utama 'admin'

<?= $this->section('content') ?> // Memulai blok konten

<div class="container mt-4 font-lora"> <!-- Container dengan margin atas dan font Lora -->
    <div class="card shadow rounded p-4 mx-auto" style="max-width: 720px;"> <!-- Kartu dengan bayangan, sudut membulat, padding, dan lebar maksimum -->
        <h4 class="mb-4 text-center">Edit Kriteria</h4> <!-- Judul form edit -->

        <form action="/admin/kriteria/update/<?= $kriteria['id'] ?>" method="post"> <!-- Form untuk update kriteria, action mengarah ke URL dengan ID -->
            <?= csrf_field() ?> // Menyisipkan CSRF token untuk keamanan form

            <?= view('kriteria/form', ['kriteria' => $kriteria]) ?> // Memuat isi form dari partial view 'kriteria/form' dengan data $kriteria

            <div class="text-center mt-3"> <!-- Area tombol submit yang diposisikan di tengah -->
                <button type="submit" class="btn btn-primary px-4">Update</button> <!-- Tombol untuk submit form dengan teks 'Update' -->
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?> // Mengakhiri blok konten
