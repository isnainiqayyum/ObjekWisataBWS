<?php

namespace App\Controllers;

// Import model Kriteria
use App\Models\KriteriaModel;

class KriteriaController extends BaseController
{
    // Properti untuk menampung instance model
    protected $kriteriaModel;

    /*************  ✨ Windsurf Command ⭐  *************/
    /**
     * Constructor.
     * Inisialisasi model KriteriaModel saat controller dibuat
     */
    /*******  0f52aa28-3cda-48dc-b09c-3d840d03cb67  *******/
    public function __construct()
    {
        // Membuat instance dari model KriteriaModel
        $this->kriteriaModel = new KriteriaModel();
    }

    // =============================
    // Method: index()
    // Tujuan: Menampilkan semua data kriteria
    // View: kriteria/index
    // =============================
    public function index()
    {
        // Ambil semua data dari tabel kriteria
        $data['kriteria'] = $this->kriteriaModel->findAll();

        // Kirim data ke view
        return view('kriteria/index', $data);
    }

    // =============================
    // Method: create()
    // Tujuan: Menampilkan form tambah kriteria
    // View: kriteria/create
    // =============================
    public function create()
    {
        return view('kriteria/create');
    }

    // =============================
    // Method: store()
    // Tujuan: Menyimpan data kriteria baru ke database
    // =============================
    public function store()
    {
        // Inisialisasi validasi dari CodeIgniter
        $validation = \Config\Services::validation();

        // Ambil data dari form POST
        $data = $this->request->getPost();

        // Aturan validasi
        $rules = [
            'nama_kriteria' => 'required|max_length[100]',
            'type' => 'required|in_list[cost,benefit]', // hanya boleh 'cost' atau 'benefit'
        ];

        // Jika validasi gagal, kembali ke halaman sebelumnya dengan pesan error
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // =============================
        // Cek total bobot sebelum insert
        // =============================
        $totalBobot = $this->kriteriaModel->selectSum('bobot')->first()['bobot'];
        $bobotBaru = (float) $data['bobot'];
        if (($totalBobot + $bobotBaru) > 1) {
            return redirect()->back()->withInput()->with('errors', ['bobot' => 'Total bobot tidak boleh lebih dari 1.']);
        }

        // Simpan data ke database
        $this->kriteriaModel->insert([
            'nama_kriteria' => $data['nama_kriteria'],
            'bobot' => $data['bobot'], // Nilai bobot dari form
            'type' => $data['type'],
        ]);

        // Redirect kembali ke halaman kriteria dengan pesan sukses
        return redirect()->route('admin/kriteria')->with('success', 'Data kriteria berhasil disimpan.');
    }

    // =============================
    // Method: edit($id)
    // Tujuan: Menampilkan form edit untuk data kriteria berdasarkan ID
    // View: kriteria/edit
    // =============================
    public function edit($id)
    {
        // Cari data kriteria berdasarkan ID
        $kriteria = $this->kriteriaModel->find($id);

        // Jika tidak ditemukan, lempar error 404
        if (!$kriteria) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data kriteria tidak ditemukan');
        }

        // Kirim data ke view edit
        return view('kriteria/edit', ['kriteria' => $kriteria]);
    }

    // =============================
    // Method: update($id)
    // Tujuan: Menyimpan perubahan data kriteria
    // =============================
    public function update($id)
    {
        // Inisialisasi validasi
        $validation = \Config\Services::validation();

        // Ambil data dari form POST
        $data = $this->request->getPost();

        // Aturan validasi input
        $rules = [
            'nama_kriteria' => 'required|max_length[100]',
            'type' => 'required|in_list[cost,benefit]',
        ];

        // Jika validasi gagal
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Lakukan update data kriteria berdasarkan ID
        $this->kriteriaModel->update($id, [
            'nama_kriteria' => $data['nama_kriteria'],
            'type' => $data['type'],
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('admin/kriteria')->with('success', 'Data kriteria berhasil diupdate.');
    }

    // =============================
    // Method: destroy($id)
    // Tujuan: Menghapus data kriteria berdasarkan ID
    // =============================
    public function destroy($id)
    {
        // Hapus data berdasarkan ID
        $this->kriteriaModel->delete($id);

        // Redirect kembali dengan pesan sukses
        return redirect()->route('admin/kriteria')->with('success', 'Data kriteria berhasil dihapus.');
    }
}
