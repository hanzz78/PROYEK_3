<?php namespace App\Controllers;

use App\Models\CourseModel;
use App\Models\StudentModel;
use App\Models\UserModel;
use CodeIgniter\Controller;

class Admin extends Controller
{
    public function __construct()
    {
        $session = session();
        if (!$session->get('isLoggedIn') || $session->get('role') != 'admin') {
            return redirect()->to(base_url());
        }
    }

    public function index()
    {
        return view('admin/dashboard');
    }

    // Mata Kuliah
    public function courses()
    {
        $model = new CourseModel();
        $data['courses'] = $model->findAll();
        return view('admin/courses/index', $data);
    }

    public function createCourse()
    {
        return view('admin/courses/create');
    }

    public function storeCourse()
    {
        $model = new CourseModel();
        $data = [
            'code' => $this->request->getVar('code'),
            'name' => $this->request->getVar('name'),
            'credits' => $this->request->getVar('credits'),
        ];
        $model->save($data);
        return redirect()->to(base_url('admin/courses'));
    }

    public function deleteCourse($id)
    {
        $model = new CourseModel();
        $model->delete($id);
        return redirect()->to(base_url('admin/courses'));
    }

    // Mahasiswa
    public function students()
    {
        $model = new StudentModel();
        $data['students'] = $model->select('students.*, users.username, users.id as user_id')
                                   ->join('users', 'users.id = students.user_id')
                                   ->findAll();
        return view('admin/students/index', $data);
    }

    public function createStudent()
    {
        return view('admin/students/create');
    }

    public function storeStudent()
    {
        $userModel = new UserModel();
        $studentModel = new StudentModel();

        // Buat akun user dulu
        $userData = [
            'username' => $this->request->getVar('username'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'role' => 'student',
        ];
        $userModel->insert($userData);
        $userId = $userModel->insertID();

        // Simpan data mahasiswa dengan user_id yang baru dibuat
        $studentData = [
            'nim' => $this->request->getVar('nim'),
            'nama_lengkap' => $this->request->getVar('nama_lengkap'),
            'umur' => $this->request->getVar('umur'),
            'user_id' => $userId,
        ];
        $studentModel->insert($studentData);

        return redirect()->to(base_url('admin/students'));
    }

    public function deleteStudent($id)
    {
        $studentModel = new StudentModel();
        $userModel = new UserModel();
        
        $student = $studentModel->find($id);
        if ($student) {
            $studentModel->delete($id);
            $userModel->delete($student['user_id']);
        }
        return redirect()->to(base_url('admin/students'));
    }
}