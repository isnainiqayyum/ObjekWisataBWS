<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class SuperAdmin extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();

        // Cek apakah pengguna adalah super admin, jika tidak arahkan ke halaman forbidden
        $session = session();
        if ($session->get('role') !== 'super_admin') {
            redirect()->to('/forbidden')->send();
            exit;
        }
    }

    // Tampilkan daftar semua user dengan role 'admin'
    public function adminIndex()
    {
        $data['users'] = $this->userModel->where('role', 'admin')->findAll();
        return view('superadmin/index', $data);
    }

    // Tampilkan form tambah admin baru
    public function adminCreate()
    {
        return view('superadmin/create');
    }

    // Simpan data admin baru ke database
    public function adminStore()
    {
        $validation = \Config\Services::validation();

        // Validasi input dari form
        $rules = [
            'username' => 'required|min_length[3]|is_unique[users.username]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]'
        ];

        // Jika validasi gagal, kembalikan ke form dengan input dan error
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Siapkan data untuk disimpan
        $data = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => 'admin', // Tetapkan role sebagai admin
        ];

        // Simpan ke database
        $this->userModel->insert($data);

        return redirect()->to('superadmin')->with('success', 'Admin berhasil ditambahkan.');
    }

    // Tampilkan form edit admin berdasarkan ID
    public function adminEdit($id)
    {
        $user = $this->userModel->find($id);

        // Jika admin tidak ditemukan atau bukan admin, tampilkan error 404
        if (!$user || $user['role'] !== 'admin') {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Admin tidak ditemukan');
        }

        return view('superadmin/edit', ['user' => $user]);
    }

    // Proses update data admin
    public function adminUpdate($id)
    {
        $user = $this->userModel->find($id);

        // Cek apakah admin valid
        if (!$user || $user['role'] !== 'admin') {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Admin tidak ditemukan');
        }

        $validation = \Config\Services::validation();

        // Validasi update data, is_unique menyesuaikan dengan id agar tidak bentrok dengan data lama
        $rules = [
            'username' => 'required|min_length[3]|is_unique[users.username,id,' . $id . ']',
            'email'    => 'required|valid_email|is_unique[users.email,id,' . $id . ']',
            'password' => 'permit_empty|min_length[6]' // Password boleh kosong jika tidak ingin diubah
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Siapkan data yang akan diupdate
        $updateData = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
        ];

        // Update password jika diisi
        $password = $this->request->getPost('password');
        if ($password) {
            $updateData['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $this->userModel->update($id, $updateData);

        return redirect()->to('superadmin')->with('success', 'Admin berhasil diupdate.');
    }

    // Hapus data admin berdasarkan ID
    public function adminDelete($id)
    {
        $user = $this->userModel->find($id);

        // Cek apakah admin valid
        if (!$user || $user['role'] !== 'admin') {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Admin tidak ditemukan');
        }

        // Hapus data admin
        $this->userModel->delete($id);

        return redirect()->to('superadmin')->with('success', 'Admin berhasil dihapus.');
    }
}
