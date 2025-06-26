<?= $this->extend('layouts/admin') ?>  <!-- Memanggil template layout bernama 'admin' -->

<?= $this->section('content') ?> <!-- Membuka section konten utama -->

<style>
    /* Style untuk mengatur tampilan container halaman */
    .container {
        max-width: 960px;
        margin: 2rem auto;
        padding: 1rem;
    }

    /* Kustomisasi tampilan card */
    .card-custom {
        background: #ffffff;
        border-radius: 0.75rem;
        box-shadow: 0 10px 15px rgba(0, 0, 0, 0.05);
        padding: 2rem;
    }

    /* Header card: judul dan (opsional) tombol */
    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        border-bottom: 1px solid #e2e8f0;
        padding-bottom: 0.5rem;
    }

    .card-header h2 {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1e293b;
        margin: 0;
    }

    /* Style tombol tambah data (jika diaktifkan) */
    /* .btn-add {
        background-color: #1e3a8a;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 500;
        text-decoration: none;
        transition: background-color 0.2s ease-in-out;
    }

    .btn-add:hover {
        background-color: #163570;
        color: white;
    } */

    /* Style tabel */
    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.9rem;
        background: #fff;
        border-radius: 0.5rem;
        overflow: hidden;
        box-shadow: 0 4px 8px rgb(0 0 0 / 0.05);
    }

    thead {
        background-color: #f8fafc;
    }

    th,
    td {
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #e2e8f0;
        vertical-align: middle;
        text-align: left;
        color: #334155;
    }

    th {
        font-weight: 600;
        color: #475569;
    }

    tbody tr:hover {
        background-color: #f1f5f9;
    }

    /* Style teks saat tidak ada data */
    .text-center {
        text-align: center;
        color: #94a3b8;
        font-style: italic;
    }

    /* Warna bintang rating */
    .stars {
        color: #fbbf24;
        font-weight: 600;
    }

    /* Spasi alert */
    .alert {
        margin-top: 1rem;
    }

    /* Style untuk pagination */
    .pagination {
        display: flex;
        justify-content: center;
        list-style: none;
        padding: 1rem 0;
        gap: 0.5rem;
    }

    .pagination li a,
    .pagination li span {
        display: inline-block;
        padding: 0.5rem 0.75rem;
        color: #1e3a8a;
        border: 1px solid #e2e8f0;
        border-radius: 0.375rem;
        text-decoration: none;
        transition: background-color 0.2s ease;
    }

    .pagination li a:hover {
        background-color: #e0e7ff;
        border-color: #6366f1;
        color: #4338ca;
    }

    .pagination li.active span {
        background-color: #1e3a8a;
        color: white;
        border-color: #1e3a8a;
        cursor: default;
    }

    /* Responsive style untuk tampilan mobile */
    @media (max-width: 576px) {
        .card-custom {
            padding: 1rem;
        }

        .card-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.75rem;
        }

        table,
        thead,
        tbody,
        th,
        td,
        tr {
            display: block;
            width: 100%;
        }

        thead {
            display: none;
        }

        tbody tr {
            margin-bottom: 1rem;
            background: #f8fafc;
            padding: 1rem;
            border-radius: 0.5rem;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
        }

        td {
            position: relative;
            padding-left: 50%;
            text-align: left;
        }

        td::before {
            content: attr(data-label);
            position: absolute;
            left: 1rem;
            top: 0.75rem;
            font-weight: 600;
            color: #2563eb;
        }
    }
</style>

<!-- Kontainer utama halaman -->
<div class="container">
    <?php if (session()->getFlashdata('success')): ?> <!-- Menampilkan pesan sukses jika ada -->
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <!-- Form pencarian -->
    <form method="get" class="mb-3">
        <div class="input-group">
            <!-- Input keyword pencarian -->
            <input type="text" name="keyword" class="form-control" placeholder="Cari nama wisata..." value="<?= esc($_GET['keyword'] ?? '') ?>">
            <!-- Tombol cari -->
            <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i> Cari</button>
        </div>
    </form>

    <!-- Card untuk menampilkan data rating -->
    <div class="card-custom">
        <div class="card-header">
            <h2>Data Rating Wisata</h2>
            <!-- Tombol tambah data (jika diaktifkan) -->
            <!-- <a href="#" class="btn-add"><i class="bi bi-plus-lg"></i> Tambah Rating</a> -->
        </div>

        <!-- Tabel daftar review -->
        <table class="table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Wisata</th>
                    <th>Rating</th>
                    <th>Komentar</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($reviews)) : ?> <!-- Cek apakah data review tersedia -->
                    <?php $no = 1 + (($pager->getCurrentPage() - 1) * $pager->getPerPage()); ?> <!-- Nomor urut berdasarkan pagination -->
                    <?php foreach ($reviews as $review) : ?> <!-- Loop data review -->
                        <tr>
                            <td data-label="No"><?= $no++ ?></td> <!-- Kolom nomor -->
                            <td data-label="Nama Wisata"><?= esc($review['nama_wisata']) ?></td> <!-- Kolom nama wisata -->
                            <td data-label="Rating" class="stars" title="<?= $review['rating'] ?> dari 5">
                                <?= str_repeat('⭐', (int)$review['rating']) ?> <!-- Menampilkan bintang sesuai rating -->
                                <small>(<?= $review['rating'] ?>)</small>
                            </td>
                            <td data-label="Komentar"><?= esc($review['komentar']) ?></td> <!-- Kolom komentar -->
                            <td data-label="Tanggal"><?= date('d-m-Y H:i', strtotime($review['created_at'])) ?></td> <!-- Kolom tanggal -->
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?> <!-- Jika tidak ada review -->
                    <tr>
                        <td colspan="5" class="text-center">Belum ada review.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Menampilkan link pagination -->
        <?= $pager->links() ?>
    </div>
</div>

<?= $this->endSection() ?> <!-- Menutup section konten -->
