<?php

namespace App\Controllers;

// Memanggil controller dasar bawaan CodeIgniter
use App\Controllers\BaseController;

// Memanggil model-model yang dibutuhkan
use App\Models\WisataModel;
use App\Models\KriteriaModel;
use App\Models\SubKriteriaModel;
use App\Models\ReviewsModels as ReviewModel; // Menggunakan alias agar tidak tabrakan nama
use CodeIgniter\HTTP\ResponseInterface;

class DashboardAdminController extends BaseController
{
    public function index()
    {
        // =======================
        // Inisialisasi model
        // =======================
        $wisataModel = new WisataModel();               // Model untuk data objek wisata
        $kriteriaModel = new KriteriaModel();           // Model untuk data kriteria penilaian
        $subKriteriaModel = new SubKriteriaModel();     // Model untuk data sub-kriteria
        $reviewModel = new ReviewModel();               // Model untuk data ulasan / review

        // =======================
        // Koneksi langsung ke database
        // =======================
        $db = \Config\Database::connect(); // Menggunakan Query Builder untuk query yang lebih kompleks

        // =======================
        // Query: Mengambil 3 wisata dengan rating tertinggi + jumlah ulasan masing-masing
        // =======================
        $topWisata = $db->table('reviews') // Mulai dari tabel reviews
            ->select('wisata.id, wisata.nama_wisata, AVG(reviews.rating) as rata_rating, COUNT(reviews.id) as total_ulasan') // Ambil ID, nama wisata, rata-rata rating, dan jumlah ulasan
            ->join('wisata', 'wisata.id = reviews.wisata_id') // Join dengan tabel wisata berdasarkan ID wisata
            ->groupBy('wisata.id') // Kelompokkan berdasarkan ID wisata agar bisa dihitung rata-rata dan jumlahnya
            ->orderBy('rata_rating', 'DESC') // Urutkan berdasarkan rating tertinggi ke terendah
            ->limit(3) // Ambil hanya 3 wisata teratas
            ->get()
            ->getResult(); // Ambil hasilnya sebagai array objek

        // =======================
        // Menyiapkan data yang akan dikirim ke tampilan (view)
        // =======================
        $data = [
            'title'             => 'Dashboard Admin',                   // Judul halaman dashboard
            'jumlahWisata'      => $wisataModel->countAll(),           // Hitung total wisata di tabel
            'jumlahKriteria'    => $kriteriaModel->countAll(),         // Hitung total kriteria di tabel
            'jumlahSubKriteria' => $subKriteriaModel->countAll(),      // Hitung total subkriteria di tabel
            'topWisata'         => $topWisata                          // Data 3 wisata dengan rating tertinggi + total ulasan
        ];

        // =======================
        // Tampilkan halaman dashboard admin dengan data yang telah disiapkan
        // =======================
        return view('admin/dashboard', $data);
    }
}
