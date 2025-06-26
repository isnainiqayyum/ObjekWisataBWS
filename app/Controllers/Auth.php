<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class Auth extends BaseController
{
    // Method untuk menampilkan halaman login
    public function login()
    {
        // Tampilkan view login
        return view('login');
    }

    // Method untuk memproses data login
    public function loginProcess()
    {
        // Ambil instance session
        $session = session();

        // Panggil model User untuk mengakses data user dari database
        $model = new UserModel();

        // Ambil data email dan password dari form POST
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Cari user berdasarkan email
        $user = $model->where('email', $email)->first();

        // Jika user ditemukan dan password cocok (menggunakan password_verify)
        if ($user && password_verify($password, $user['password'])) {
            // Simpan data user ke session
            $session->set([
                'user_id'   => $user['id'],           // ID user
                'username'  => $user['username'],     // Username
                'email'     => $user['email'],        // Email
                'role'      => $user['role'],         // Role (misal: super_admin/admin)
                'logged_in' => true                   // Flag bahwa user sudah login
            ]);

            // Arahkan user ke halaman sesuai role-nya
            if ($user['role'] === 'super_admin') {
                return redirect()->to('/superadmin'); // Jika super_admin, arahkan ke halaman superadmin
            } else {
                return redirect()->to('/admin/dashboard'); // Jika admin biasa, ke dashboard admin
            }
        } else {
            // Jika email/password tidak cocok, kembalikan ke halaman login dengan pesan error
            return redirect()->back()->with('error', 'Email atau Password salah');
        }
    }

    // Method untuk logout user
    public function logout()
    {
        // Hancurkan semua session
        session()->destroy();

        // Redirect ke halaman login
        return redirect()->to('/login');
    }
}
