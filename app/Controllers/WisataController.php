<?php

namespace App\Controllers;

// Memanggil model Wisata dan SubKriteria yang akan digunakan
use App\Models\WisataModel;
use App\Models\SubKriteriaModel;

class WisataController extends BaseController
{
    // Mendefinisikan properti untuk model
    protected $wisataModel;
    protected $subKriteriaModel;

    // Konstruktor: menginisialisasi model yang dibutuhkan
    public function __construct()
    {
        $this->wisataModel = new WisataModel();
        $this->subKriteriaModel = new SubKriteriaModel();
    }

    // Method untuk menampilkan daftar wisata
    public function index()
    {
        // Mengambil data wisata dan join dengan tabel sub_kriteria
        $data['wisata'] = $this->wisataModel
            ->select('wisata.*, sub_kriteria.nama as sub_kriteria_nama')
            ->join('sub_kriteria', 'wisata.sub_kriteria_id = sub_kriteria.id')
            ->paginate(10); // Paginasi 10 data per halaman

        $data['pager'] = $this->wisataModel->pager; // Untuk navigasi halaman

        return view('wisata/index', $data); // Menampilkan view
    }

    // Menampilkan form tambah data wisata
    public function create()
    {
        // Mengambil data sub_kriteria yang memiliki kriteria_id = 1
        $subKriteriaModel = new SubKriteriaModel();
        $data['subkriteria'] = $subKriteriaModel->where('kriteria_id', 1)->findAll();

        return view('wisata/create', $data); // Menampilkan view form tambah
    }

    // Menyimpan data wisata baru ke database
    public function store()
    {
        // Aturan validasi input
        $validationRules = [
            'nama_wisata'      => 'required',
            'alamat'           => 'required',
            'sub_kriteria_id'  => 'required',
            'gambar' => [
                'uploaded[gambar]',
                'is_image[gambar]',
                'max_size[gambar,2048]' // Maksimum 2MB
            ]
        ];

        // Pesan validasi khusus
        $validationMessages = [
            'nama_wisata' => ['required' => 'Nama wisata wajib diisi.'],
            'alamat' => ['required' => 'Alamat wajib diisi.'],
            'sub_kriteria_id' => ['required' => 'Sub kriteria wajib dipilih.'],
            'gambar' => [
                'uploaded' => 'Gambar wajib diunggah.',
                'is_image' => 'File yang diunggah harus berupa gambar.',
                'max_size' => 'Ukuran gambar tidak boleh lebih dari 2MB.'
            ]
        ];

        // Jika validasi gagal, kembali ke halaman sebelumnya dengan error
        if (!$this->validate($validationRules, $validationMessages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Menangani upload gambar
        $file = $this->request->getFile('gambar');
        $namaGambar = $file->getRandomName(); // Mengacak nama file
        $file->move('assets/images', $namaGambar); // Menyimpan file ke folder

        // Menyimpan data ke database
        $this->wisataModel->insert([
            'nama_wisata' => $this->request->getPost('nama_wisata'),
            'alamat' => $this->request->getPost('alamat'),
            'gambar' => $namaGambar,
            'sub_kriteria_id' => $this->request->getPost('sub_kriteria_id'),
        ]);

        return redirect()->to('/admin/wisata')->with('success', 'Data berhasil ditambahkan');
    }

    // Menampilkan form edit untuk wisata tertentu berdasarkan ID
    public function edit($id)
    {
        // Mengambil sub kriteria dan data wisata yang akan diedit
        $subKriteriaModel = new SubKriteriaModel();
        $data['subkriteria'] = $subKriteriaModel->where('kriteria_id', 1)->findAll();
        $data['wisata'] = $this->wisataModel->find($id);

        return view('wisata/edit', $data); // Menampilkan view form edit
    }

    // Memproses pembaruan data wisata
    public function update($id)
    {
        // Mengambil data wisata berdasarkan ID
        $wisata = $this->wisataModel->find($id);

        // Aturan validasi (gambar tetap wajib diunggah)
        $validationRules = [
            'nama_wisata'      => 'required',
            'alamat'           => 'required',
            'sub_kriteria_id'  => 'required',
            'gambar' => [
                'uploaded[gambar]',
                'is_image[gambar]',
                'max_size[gambar,2048]'
            ]
        ];

        // Pesan error validasi
        $validationMessages = [
            'nama_wisata' => ['required' => 'Nama wisata wajib diisi.'],
            'alamat' => ['required' => 'Alamat wajib diisi.'],
            'sub_kriteria_id' => ['required' => 'Sub kriteria wajib dipilih.'],
            'gambar' => [
                'uploaded' => 'Gambar wajib diunggah.',
                'is_image' => 'File yang diunggah harus berupa gambar.',
                'max_size' => 'Ukuran gambar tidak boleh lebih dari 2MB.'
            ]
        ];

        // Validasi input
        if (!$this->validate($validationRules, $validationMessages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Tangani gambar baru
        $file = $this->request->getFile('gambar');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Generate nama file baru dan pindahkan ke folder
            $namaGambar = $file->getRandomName();
            $file->move('assets/images', $namaGambar);

            // Hapus gambar lama jika ada
            if ($wisata['gambar'] && file_exists('assets/images/' . $wisata['gambar'])) {
                unlink('assets/images/' . $wisata['gambar']);
            }
        } else {
            // Jika tidak ada gambar baru, gunakan yang lama
            $namaGambar = $wisata['gambar'];
        }

        // Update data ke database
        $this->wisataModel->update($id, [
            'nama_wisata' => $this->request->getPost('nama_wisata'),
            'alamat' => $this->request->getPost('alamat'),
            'gambar' => $namaGambar,
            'sub_kriteria_id' => $this->request->getPost('sub_kriteria_id'),
        ]);

        return redirect()->to('/admin/wisata')->with('success', 'Data berhasil diperbarui');
    }

    // Menghapus data wisata
    public function delete($id)
    {
        // Menghapus data berdasarkan ID
        $this->wisataModel->delete($id);
        return redirect()->to('/admin/wisata');
    }
}
