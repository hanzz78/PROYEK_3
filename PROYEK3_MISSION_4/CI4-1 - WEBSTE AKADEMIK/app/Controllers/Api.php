<?php namespace App\Controllers;

use App\Models\CourseModel;
use App\Models\StudentModel;
use App\Models\UserModel;
use App\Models\EnrollmentModel;
use CodeIgniter\Controller;

class Api extends Controller
{
    protected $format = 'json';

    public function login()
    {
        $input = $this->request->getJSON();
        $userModel = new UserModel();

        $user = $userModel->where('username', $input->username)->first();

        if ($user && password_verify($input->password, $user['password'])) {
            $session = session();
            $data = [
                'user_id' => $user['id'],
                'role'    => $user['role'],
            ];
            $session->set($data);

            return $this->response->setJSON(['success' => true, 'role' => $user['role']]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Username atau password salah.']);
        }
    }

    // --- Admin Endpoints ---

    public function getAdminCourses()
    {
        $model = new CourseModel();
        return $this->response->setJSON($model->findAll());
    }

    public function createAdminCourse()
    {
        $input = $this->request->getJSON();
        $model = new CourseModel();
        $model->insert((array)$input);
        return $this->response->setJSON(['success' => true]);
    }

    public function deleteAdminCourse($id)
    {
        $model = new CourseModel();
        $model->delete($id);
        return $this->response->setJSON(['success' => true]);
    }

    public function getAdminStudents()
    {
        $studentModel = new StudentModel();
        $students = $studentModel->select('students.*, users.username, users.id as user_id')
                                 ->join('users', 'users.id = students.user_id')
                                 ->findAll();
        return $this->response->setJSON($students);
    }
    
    public function getStudentData($id)
    {
        $studentModel = new StudentModel();
        $student = $studentModel->select('students.*, users.username, users.id as user_id')
                                ->join('users', 'users.id = students.user_id')
                                ->where('students.id', $id)
                                ->first();
        return $this->response->setJSON($student);
    }

    public function createAdminStudent()
    {
        $input = $this->request->getJSON();
        $userModel = new UserModel();
        $studentModel = new StudentModel();

        // Buat akun user dulu
        $userData = [
            'username' => $input->username,
            'password' => password_hash($input->password, PASSWORD_DEFAULT),
            'role' => 'student',
        ];
        $userModel->insert($userData);
        $userId = $userModel->insertID();

        // Simpan data mahasiswa
        $studentData = [
            'nim' => $input->nim,
            'nama_lengkap' => $input->nama_lengkap,
            'umur' => $input->umur,
            'user_id' => $userId,
        ];
        $studentModel->insert($studentData);

        return $this->response->setJSON(['success' => true]);
    }

    public function updateAdminStudent($id)
    {
        $input = $this->request->getJSON();
        $studentModel = new StudentModel();
        $userModel = new UserModel();

        $student = $studentModel->find($id);

        if ($student) {
            // Update data user
            $userData = ['username' => $input->username];
            if ($input->password) {
                $userData['password'] = password_hash($input->password, PASSWORD_DEFAULT);
            }
            $userModel->update($student['user_id'], $userData);

            // Update data mahasiswa
            $studentData = [
                'nim' => $input->nim,
                'nama_lengkap' => $input->nama_lengkap,
                'umur' => $input->umur,
            ];
            $studentModel->update($id, $studentData);

            return $this->response->setJSON(['success' => true]);
        }
        return $this->response->setJSON(['success' => false, 'message' => 'Mahasiswa tidak ditemukan.']);
    }
    
    public function deleteAdminStudent($id)
    {
        $studentModel = new StudentModel();
        $userModel = new UserModel();
        
        $student = $studentModel->find($id);
        if ($student) {
            $studentModel->delete($id);
            $userModel->delete($student['user_id']);
        }
        return $this->response->setJSON(['success' => true]);
    }

    // --- Student Endpoints ---

    public function getStudentCourses()
    {
        $model = new CourseModel();
        return $this->response->setJSON($model->findAll());
    }

    public function getStudentEnrollments()
    {
        $session = session();
        $studentModel = new StudentModel();
        $enrollmentModel = new EnrollmentModel();
        
        $userId = $session->get('user_id');
        $student = $studentModel->where('user_id', $userId)->first();
        
        if ($student) {
            $enrollments = $enrollmentModel->where('student_id', $student['id'])->findAll();
            return $this->response->setJSON($enrollments);
        }
        return $this->response->setJSON([]);
    }

    public function enrollStudentCourses()
    {
        $input = $this->request->getJSON();
        $session = session();
        $studentModel = new StudentModel();
        $enrollmentModel = new EnrollmentModel();

        $userId = $session->get('user_id');
        $student = $studentModel->where('user_id', $userId)->first();
        
        if ($student && isset($input->courses) && is_array($input->courses)) {
            foreach ($input->courses as $courseId) {
                // Cek apakah mata kuliah sudah di-enroll
                $isEnrolled = $enrollmentModel->where('student_id', $student['id'])
                                              ->where('course_id', $courseId)
                                              ->first();
                if (!$isEnrolled) {
                    $enrollmentModel->insert([
                        'student_id' => $student['id'],
                        'course_id' => $courseId,
                    ]);
                }
            }
        }
        return $this->response->setJSON(['success' => true]);
    }
}