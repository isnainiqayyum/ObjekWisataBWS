<?php

namespace App\Controllers;

// Extend controller dasar dari CodeIgniter
use App\Controllers\BaseController;

// Import model yang dibutuhkan
use App\Models\WisataModel;         // Model untuk data wisata
use App\Models\ReviewsModels;       // Model untuk data ulasan
use App\Models\SubKriteriaModel;    // Model untuk data sub-kriteria (jenis wisata)

class HomeController extends BaseController
{
    // ========================
    // Method: index()
    // Tujuan: Menampilkan halaman landing page utama
    // ========================
    public function index()
    {
        // Inisialisasi model wisata
        $wisataModel = new WisataModel();

        // Ambil semua data wisata dari database
        $wisata = $wisataModel->findAll();

        // Kirim data ke view landing page (folder: user/landing_page)
        return view('user/landing_page/index', ['wisata' => $wisata]);
    }

    // ========================
    // Method: detail($id)
    // Tujuan: Menampilkan detail salah satu wisata berdasarkan ID
    // ========================
    public function detail($id)
    {
        // Inisialisasi semua model yang digunakan
        $wisataModel = new WisataModel();            // Model wisata
        $reviewModel = new ReviewsModels();          // Model ulasan
        $subModel = new SubKriteriaModel();          // Model sub-kriteria (jenis wisata)

        // Ambil data wisata berdasarkan ID
        $wisata = $wisataModel->find($id);

        // Jika data wisata tidak ditemukan, tampilkan halaman error 404
        if (!$wisata) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Wisata tidak ditemukan.");
        }

        // Ambil semua ulasan berdasarkan wisata_id dan urutkan dari yang terbaru
        $ulasan = $reviewModel->where('wisata_id', $id)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        // Hitung rata-rata rating dan jumlah total ulasan dari review
        $rating = $reviewModel->select('AVG(rating) as avg_rating, COUNT(*) as total_ulasan')
            ->where('wisata_id', $id)
            ->get()
            ->getRow();

        // Ambil data sub-kriteria (jenis wisata) berdasarkan foreign key dari tabel wisata
        $jenisWisata = $subModel->find($wisata['sub_kriteria_id']);

        // Kirim semua data ke view detail wisata (folder: user/wisata)
        return view('user/wisata/detail', [
            'wisata'       => $wisata,        // Data wisata utama
            'ulasan'       => $ulasan,        // Semua ulasan terkait wisata
            'rating'       => $rating,        // Rata-rata rating & total ulasan
            'jenisWisata'  => $jenisWisata    // Informasi jenis wisata dari sub_kriteria
        ]);
    }
}
