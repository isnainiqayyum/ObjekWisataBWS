<?= $this->extend('layouts/admin') ?> 
<?= $this->section('content') ?> 

<style>
    /* Container utama dengan padding dan margin tengah */
    .container {
        max-width: 960px;
        margin: 2rem auto;
        padding: 1rem;
    }

    /* Tampilan kartu konten */
    .card-custom {
        background: #ffffff;
        border-radius: 0.75rem;
        box-shadow: 0 10px 15px rgba(0, 0, 0, 0.05);
        padding: 2rem;
    }

    /* Header pada card: posisi judul dan tombol */
    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        border-bottom: 1px solid #e2e8f0;
        padding-bottom: 0.5rem;
    }

    /* Judul header card */
    .card-header h2 {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1e293b;
        margin: 0;
    }

    /* Tombol tambah data */
    .btn-add {
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

    /* Efek hover tombol tambah data */
    .btn-add:hover {
        background-color: #163570;
        color: white;
    }

    /* Tabel: lebar penuh, tidak ada jarak antar sel */
    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.9rem;
    }

    /* Header tabel */
    thead {
        background-color: #f8fafc;
    }

    /* Sel tabel */
    th,
    td {
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #e2e8f0;
        vertical-align: middle;
        text-align: left;
    }

    /* Gaya teks untuk header tabel */
    th {
        font-weight: 600;
        color: #475569;
    }

    /* Gaya teks isi tabel */
    td {
        color: #334155;
    }

    /* Efek hover untuk baris tabel */
    .table-hover tbody tr:hover {
        background-color: #f1f5f9;
    }

    /* Tombol aksi edit/hapus di dalam tabel */
    .action-icons {
        display: flex;
        gap: 0.5rem;
    }

    /* Link dan tombol dalam aksi */
    .action-icons a,
    .action-icons button {
        color: #1e3a8a;
        background: none;
        border: none;
        font-size: 1.1rem;
        padding: 0;
        cursor: pointer;
        transition: color 0.2s ease;
    }

    /* Efek hover tombol aksi */
    .action-icons a:hover,
    .action-icons button:hover {
        color: #0f172a;
    }

    /* Gaya teks untuk keterangan tidak ada data */
    .text-muted {
        color: #94a3b8;
        font-style: italic;
    }

    /* Margin atas untuk alert */
    .alert {
        margin-top: 1rem;
    }

    /* Responsif: tampilan tabel di perangkat kecil */
    @media (max-width: 576px) {
        .card-custom {
            padding: 1rem;
        }

        .card-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.75rem;
        }

        /* Menjadikan tabel sebagai blok pada mobile */
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

        /* Tampilan baris tabel versi mobile */
        tbody tr {
            margin-bottom: 1rem;
            background: #f8fafc;
            padding: 1rem;
            border-radius: 0.5rem;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
        }

        /* Penyesuaian posisi label pada sel */
        td {
            position: relative;
            padding-left: 50%;
            text-align: left;
        }

        /* Label responsif */
        td::before {
            content: attr(data-label);
            position: absolute;
            left: 1rem;
            top: 0.75rem;
            font-weight: 600;
            color: #2563eb;
        }

        /* Penyesuaian ikon aksi */
        .action-icons {
            justify-content: flex-end;
        }
    }
</style>

<div class="container">
    <?php if (session()->getFlashdata('success')): ?>
        <!-- Menampilkan alert jika ada pesan sukses -->
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <div class="card-custom">
        <!-- Form Search -->
        <form method="get" class="mb-3">
            <input type="text" name="search" placeholder="Cari nama wisata..." value="<?= esc($search) ?? '' ?>" style="padding: 0.5rem; border-radius: 0.5rem; border: 1px solid #ccc;">
            <button type="submit" style="padding: 0.5rem 1rem; background-color: #1e3a8a; color: white; border: none; border-radius: 0.5rem;">
                Cari
            </button>
        </form>

        <div class="card-header">
            <h2>Data Nilai Alternatif</h2>
            <!-- Tombol menuju halaman tambah data -->
            <a href="<?= site_url('admin/nilai-alternatif/create') ?>" class="btn-add">
                <i class="bi bi-plus-lg"></i> Tambah Data
            </a>
        </div>

        <!-- Tabel menampilkan data nilai alternatif -->
        <table class="table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Wisata</th>
                    <th>Sub Kriteria</th>
                    <th>Nilai</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($nilaiAlternatif)): ?>
                    <?php foreach ($nilaiAlternatif as $item): ?>
                        <!-- Menampilkan setiap baris data -->
                        <tr>
                            <td data-label="ID"><?= $item['id'] ?></td>
                            <td data-label="Wisata"><?= esc($item['nama_wisata']) ?></td>
                            <td data-label="Sub Kriteria"><?= esc($item['nama_sub_kriteria']) ?></td>
                            <td data-label="Nilai"><?= esc($item['nilai']) ?></td>
                            <td data-label="Aksi">
                                <div class="action-icons">
                                    <!-- Tombol edit -->
                                    <a href="<?= site_url('admin/nilai-alternatif/edit/' . $item['id']) ?>" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <!-- Form hapus -->
                                    <form action="<?= site_url('admin/nilai-alternatif/delete/' . $item['id']) ?>" method="post" onsubmit="return confirm('Yakin hapus?');">
                                        <?= csrf_field() ?>
                                        <button type="submit" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach ?>
                <?php else: ?>
                    <!-- Pesan jika data kosong -->
                    <tr>
                        <td colspan="5" class="text-center text-muted">Belum ada data nilai alternatif.</td>
                    </tr>
                <?php endif ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?> // Menutup bagian konten
