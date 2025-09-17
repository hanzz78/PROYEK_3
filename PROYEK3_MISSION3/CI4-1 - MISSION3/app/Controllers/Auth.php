<?php namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController {

    public function loginForm() {
        return view('auth/login');
    }

    public function login() {
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $model = new UserModel();
        $user  = $model->where('email', $email)->first();

        if (!$user || $user['password'] !== md5($password)) {
            return redirect()->back()->with('error','Email atau password salah');
        }

        session()->set([
            'isLoggedIn' => true,
            'user_id'    => $user['user_id'],
            'full_name'  => $user['full_name'],
            'email'      => $user['email'],
            'role'       => $user['role']
        ]);

        return $user['role'] === 'admin'
            ? redirect()->to('/admin/home')
            : redirect()->to('/student/home');
    }

    public function logout() {
        session()->destroy();
        return redirect()->to('/login');
    }

    public function registerForm() {
        return view('auth/register');
    }

    public function register() {
        $model = new UserModel();
        $db    = \Config\Database::connect();

        $data = [
            'full_name' => $this->request->getPost('full_name'),
            'email'     => $this->request->getPost('email'),
            'password'  => md5($this->request->getPost('password')),
            'role'      => 'student'
        ];
        $model->insert($data);

        $userId = $model->insertID();

        $db->table('students')->insert([
            'student_id' => $userId,
            'entry_year' => date('Y'),
            'major'      => 'Informatika'
        ]);

        return redirect()->to('/login')->with('success','Registrasi berhasil');
    }
}
