<?php

namespace App\Controllers;

// Mengimpor model SubKriteria dan Kriteria
use App\Models\SubKriteriaModel;
use App\Models\KriteriaModel;

class SubKriteriaController extends BaseController
{
    // Deklarasi properti model
    protected $subKriteriaModel;
    protected $kriteriaModel;

    // Konstruktor untuk inisialisasi model
    public function __construct()
    {
        // Inisialisasi model SubKriteria
        $this->subKriteriaModel = new SubKriteriaModel();
        // Inisialisasi model Kriteria
        $this->kriteriaModel = new KriteriaModel();
    }

    // Fungsi untuk menampilkan semua data sub-kriteria
    public function index()
    {
        $data['subkriteria'] = $this->subKriteriaModel
            ->select('sub_kriteria.*, kriteria.nama_kriteria') // Ambil semua kolom sub_kriteria dan nama_kriteria
            ->join('kriteria', 'kriteria.id = sub_kriteria.kriteria_id') // Gabung tabel kriteria berdasarkan kriteria_id
            ->orderBy('sub_kriteria.id', 'ASC') // Urutkan berdasarkan ID sub_kriteria secara ascending
            ->findAll(); // Ambil semua data

        // Tampilkan data ke view 'sub-kriteria/index'
        return view('sub-kriteria/index', $data);
    }

    // Fungsi untuk menampilkan form tambah sub-kriteria
    public function create()
    {
        // Ambil semua data kriteria untuk ditampilkan dalam dropdown
        $data['kriteria'] = $this->kriteriaModel->findAll();

        // Tampilkan form tambah ke view 'sub-kriteria/create'
        return view('sub-kriteria/create', $data);
    }

    // Fungsi untuk menyimpan data sub-kriteria baru ke database
    public function store()
    {
        // Simpan data yang dikirim dari form ke tabel sub_kriteria
        $this->subKriteriaModel->save([
            'kriteria_id' => $this->request->getPost('kriteria_id'), // Ambil nilai kriteria_id dari form
            'nama'        => $this->request->getPost('nama'),        // Ambil nama sub-kriteria
        ]);

        // Redirect ke halaman sub-kriteria dengan pesan sukses
        return redirect()->to('admin/sub-kriteria')->with('success', 'Data berhasil ditambahkan.');
    }

    // Fungsi untuk menampilkan form edit sub-kriteria
    public function edit($id)
    {
        // Ambil data sub-kriteria berdasarkan ID
        $data['subkriteria'] = $this->subKriteriaModel->find($id);
        // Ambil semua kriteria untuk dropdown pilihan
        $data['kriteria'] = $this->kriteriaModel->findAll();

        // Tampilkan form edit ke view 'sub-kriteria/edit'
        return view('sub-kriteria/edit', $data);
    }

    // Fungsi untuk menyimpan perubahan data sub-kriteria
    public function update($id)
    {
        // Update data berdasarkan ID dengan data dari form
        $this->subKriteriaModel->update($id, [
            'kriteria_id' => $this->request->getPost('kriteria_id'), // ID kriteria yang dipilih
            'nama'        => $this->request->getPost('nama'),        // Nama sub-kriteria yang diubah
        ]);

        // Redirect ke halaman sub-kriteria dengan pesan sukses
        return redirect()->to('admin/sub-kriteria')->with('success', 'Data berhasil diperbarui.');
    }

    // Fungsi untuk menghapus data sub-kriteria berdasarkan ID
    public function destroy($id)
    {
        // Hapus data sub-kriteria
        $this->subKriteriaModel->delete($id);

        // Redirect ke halaman sub-kriteria dengan pesan sukses
        return redirect()->to('admin/sub-kriteria')->with('success', 'Data berhasil dihapus.');
    }
}
