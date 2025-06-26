<?php

namespace App\Controllers;

// Mengimpor model yang digunakan
use App\Models\NilaiAlternatifModel;
use App\Models\WisataModel;
use App\Models\SubKriteriaModel;

class NilaiAlternatifController extends BaseController
{
    // Properti untuk menyimpan instance dari model
    protected $nilaiAlternatifModel;
    protected $wisataModel;
    protected $subKriteriaModel;

    // Konstruktor: Menginisialisasi model yang akan digunakan
    public function __construct()
    {
        $this->nilaiAlternatifModel = new NilaiAlternatifModel();
        $this->wisataModel = new WisataModel();
        $this->subKriteriaModel = new SubKriteriaModel();
    }

    // Menampilkan daftar semua data nilai alternatif
    public function index()
    {
        // Tangkap parameter pencarian dari input GET
        $search = $this->request->getGet('search');

        // Gunakan builder untuk join tabel wisata dan sub_kriteria
        $builder = $this->nilaiAlternatifModel->builder();
        $builder->select('nilai_alternatif.*, wisata.nama_wisata, sub_kriteria.nama as nama_sub_kriteria');
        $builder->join('wisata', 'wisata.id = nilai_alternatif.wisata_id');
        $builder->join('sub_kriteria', 'sub_kriteria.id = nilai_alternatif.sub_kriteria_id');

        // Jika ada input pencarian, tambahkan klausa LIKE
        if (!empty($search)) {
            $builder->like('wisata.nama_wisata', $search);
        }

        // Ambil hasil query
        $data['nilaiAlternatif'] = $builder->get()->getResultArray();

        // Kirim data search ke view agar tetap muncul di input
        $data['search'] = $search;

        // Tampilkan view
        return view('nilai-alternatif/index', $data);
    }
    // Menampilkan form untuk menambahkan nilai alternatif baru
    public function create()
    {
        // Mengambil semua data wisata dan subkriteria untuk dropdown form
        $data['wisata'] = $this->wisataModel->findAll();
        $data['subkriteria'] = $this->subKriteriaModel->findAll();

        // Menampilkan view form create
        return view('nilai-alternatif/create', $data);
    }

    // Menyimpan data nilai alternatif yang dikirim dari form
    public function store()
    {
        // Mengambil data dari form
        $data = [
            'wisata_id' => $this->request->getPost('wisata_id'),
            'sub_kriteria_id' => $this->request->getPost('sub_kriteria_id'),
            'nilai' => $this->request->getPost('nilai'),
        ];

        // Menyimpan data ke database
        $this->nilaiAlternatifModel->save($data);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->to('/admin/nilai-alternatif')->with('success', 'Data berhasil ditambahkan.');
    }

    // Menampilkan form edit untuk data tertentu berdasarkan ID
    public function edit($id)
    {
        // Mengambil data nilai alternatif berdasarkan ID
        $nilai = $this->nilaiAlternatifModel->find($id);

        // Jika data tidak ditemukan, redirect kembali dengan pesan error
        if (!$nilai) {
            return redirect()->to('/admin/nilai-alternatif')->with('error', 'Data tidak ditemukan.');
        }

        // Menyediakan data nilai, wisata, dan subkriteria ke view edit
        $data['nilai'] = $nilai;
        $data['wisata'] = $this->wisataModel->findAll();
        $data['subkriteria'] = $this->subKriteriaModel->findAll();

        // Menampilkan view edit
        return view('nilai-alternatif/edit', $data);
    }

    // Menyimpan perubahan dari form edit ke database
    public function update($id)
    {
        // Mengambil data dari form
        $data = [
            'wisata_id' => $this->request->getPost('wisata_id'),
            'sub_kriteria_id' => $this->request->getPost('sub_kriteria_id'),
            'nilai' => $this->request->getPost('nilai'),
        ];

        // Memperbarui data berdasarkan ID
        $this->nilaiAlternatifModel->update($id, $data);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->to('/admin/nilai-alternatif')->with('success', 'Data berhasil diperbarui.');
    }

    // Menghapus data nilai alternatif berdasarkan ID
    public function delete($id)
    {
        // Menghapus data dari database
        $this->nilaiAlternatifModel->delete($id);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->to('/admin/nilai-alternatif')->with('success', 'Data berhasil dihapus.');
    }
}
