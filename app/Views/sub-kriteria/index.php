<?= $this->extend('layouts/admin') ?> <!-- Memanggil layout utama 'admin' -->
<?= $this->section('content') ?> <!-- Membuka section konten utama -->

<style>
    /* Style utama container */
    .container {
        max-width: 960px;
        margin: 2rem auto;
        padding: 1rem;
    }

    /* Style kartu custom */
    .card-custom {
        background: #ffffff;
        border-radius: 0.75rem;
        box-shadow: 0 10px 15px rgba(0, 0, 0, 0.05);
        padding: 2rem;
    }

    /* Style header pada kartu */
    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        border-bottom: 1px solid #e2e8f0;
        padding-bottom: 0.5rem;
    }

    /* Judul dalam header */
    .card-header h2 {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1e293b;
        margin: 0;
    }

    /* Tombol tambah */
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

    /* Hover efek tombol tambah */
    .btn-add:hover {
        background-color: #163570;
        color: white;
    }

    /* Style untuk tabel */
    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.9rem;
    }

    /* Style header tabel */
    thead {
        background-color: #f8fafc;
    }

    /* Style umum kolom */
    th,
    td {
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #e2e8f0;
        vertical-align: middle;
        text-align: left;
    }

    /* Style khusus header */
    th {
        font-weight: 600;
        color: #475569;
    }

    /* Style isi kolom */
    td {
        color: #334155;
    }

    /* Efek hover pada baris tabel */
    .table-hover tbody tr:hover {
        background-color: #f1f5f9;
    }

    /* Ikon aksi (edit & hapus) */
    .action-icons {
        display: flex;
        gap: 0.5rem;
    }

    /* Style link dan button dalam ikon aksi */
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

    /* Hover ikon aksi */
    .action-icons a:hover,
    .action-icons button:hover {
        color: #0f172a;
    }

    /* Teks muted */
    .text-muted {
        color: #94a3b8;
        font-style: italic;
    }

    /* Notifikasi alert */
    .alert {
        margin-top: 1rem;
    }

    /* Responsif mobile */
    @media (max-width: 576px) {
        .card-custom {
            padding: 1rem;
        }

        .card-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.75rem;
        }

        /* Buat tabel menjadi blok saat di mobile */
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

        /* Label kolom saat responsif */
        td::before {
            content: attr(data-label);
            position: absolute;
            left: 1rem;
            top: 0.75rem;
            font-weight: 600;
            color: #2563eb;
        }

        .action-icons {
            justify-content: flex-end;
        }
    }
</style>

<div class="container"> <!-- Kontainer utama -->

    <?php if (session()->getFlashdata('success')): ?> <!-- Cek apakah ada flashdata success -->
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div> <!-- Tampilkan alert -->
    <?php endif; ?>

    <div class="card-custom"> <!-- Kartu berisi data -->
        <div class="card-header"> <!-- Header kartu -->
            <h2>Data Sub Kriteria</h2> <!-- Judul halaman -->
            <a href="<?= route_to('admin/sub-kriteria/create') ?>" class="btn-add"> <!-- Tombol tambah data -->
                <i class="bi bi-plus-lg"></i> Tambah Sub Kriteria
            </a>
        </div>

        <table class="table-hover"> <!-- Tabel data -->
            <thead>
                <tr>
                    <th>#</th> <!-- Nomor urut -->
                    <th>Nama Sub Kriteria</th> <!-- Nama sub kriteria -->
                    <th>Kriteria</th> <!-- Nama kriteria induk -->
                    <th style="width: 100px;">Aksi</th> <!-- Kolom aksi -->
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($subkriteria)): ?> <!-- Jika data tidak kosong -->
                    <?php $i = 1;
                    foreach ($subkriteria as $sk): ?> <!-- Looping data sub kriteria -->
                        <tr>
                            <td data-label="#"> <?= $i++ ?> </td> <!-- Nomor urut -->
                            <td data-label="Nama Sub Kriteria"><?= esc($sk['nama']) ?></td> <!-- Nama sub kriteria -->
                            <td data-label="Kriteria"><?= esc($sk['nama_kriteria']) ?></td> <!-- Nama kriteria -->
                            <td data-label="Aksi">
                                <div class="action-icons"> <!-- Ikon aksi -->
                                    <a href="/admin/sub-kriteria/edit/<?= $sk['id'] ?>" title="Edit"> <!-- Tombol edit -->
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="/admin/sub-kriteria/delete/<?= $sk['id'] ?>" method="post" onsubmit="return confirm('Yakin ingin menghapus data ini?');"> <!-- Form hapus -->
                                        <?= csrf_field() ?> <!-- Token keamanan -->
                                        <button type="submit" title="Hapus"> <!-- Tombol hapus -->
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach ?>
                <?php else: ?> <!-- Jika tidak ada data -->
                    <tr>
                        <td colspan="4" class="text-center text-muted">Belum ada data sub kriteria.</td>
                    </tr>
                <?php endif ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?> <!-- Menutup section konten -->
