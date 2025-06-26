<?php

namespace App\Controllers;

// Menggunakan BaseController bawaan CI4
use App\Controllers\BaseController;
// Memanggil model untuk ulasan
use App\Models\ReviewsModels;
use CodeIgniter\HTTP\ResponseInterface;

class ReviewsController extends BaseController
{
    // Fungsi untuk menampilkan daftar review
    public function index()
    {
        // Inisialisasi model review
        $reviewModel = new ReviewsModels();

        // Ambil nilai pencarian dari parameter GET (misal: ?keyword=ijen)
        $keyword = $this->request->getGet('keyword');

        // Menentukan data yang akan diambil: semua kolom dari reviews dan nama_wisata dari tabel wisata
        $reviewModel->select('reviews.*, wisata.nama_wisata')
                    ->join('wisata', 'wisata.id = reviews.wisata_id'); // Melakukan join ke tabel wisata

        // Jika user memasukkan keyword pencarian
        if (!empty($keyword)) {
            // Filter hasil berdasarkan nama_wisata yang mirip dengan keyword
            $reviewModel->like('wisata.nama_wisata', $keyword);
        }

        // Urutkan review berdasarkan tanggal terbaru dan batasi tampilan per halaman
        $reviews = $reviewModel->orderBy('reviews.created_at', 'DESC')
                               ->paginate(10); // Menampilkan 10 data per halaman

        // Ambil objek pager untuk digunakan pada view (paginasi)
        $pager = $reviewModel->pager;

        // Kirim data ke tampilan view 'reviews/index'
        return view('reviews/index', [
            'reviews' => $reviews,    // Data ulasan
            'pager'   => $pager,      // Data pagination
            'keyword' => $keyword,    // Keyword pencarian untuk ditampilkan ulang di input
        ]);
    }

    // Fungsi untuk menyimpan ulasan baru
    public function simpan()
    {
        // Ambil service validasi dari CodeIgniter
        $validation = \Config\Services::validation();

        // Aturan validasi input dari form review
        $validation->setRules([
            'wisata_id' => 'required|is_natural_no_zero',                 // wisata_id harus diisi dan bilangan bulat positif
            'rating'    => 'required|integer|greater_than[0]|less_than_equal_to[5]', // rating harus 1-5
            'komentar'  => 'permit_empty|string|max_length[1000]',       // komentar opsional, max 1000 karakter
        ]);

        // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan input dan error
        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()
                             ->withInput()                     // Menyimpan input sebelumnya
                             ->with('errors', $validation->getErrors()); // Kirim pesan error
        }

        // Jika validasi berhasil, simpan data review ke database
        $reviewModel = new ReviewsModels();
        $reviewModel->insert([
            'wisata_id' => $this->request->getPost('wisata_id'), // Ambil ID wisata dari form
            'rating'    => $this->request->getPost('rating'),    // Ambil nilai rating
            'komentar'  => $this->request->getPost('komentar'),  // Ambil komentar
        ]);

        // Redirect kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Ulasan berhasil dikirim!');
    }
}
