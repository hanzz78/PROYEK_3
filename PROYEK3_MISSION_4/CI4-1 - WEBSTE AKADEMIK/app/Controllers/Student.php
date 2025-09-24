<?php namespace App\Controllers;

use App\Models\CourseModel;
use App\Models\EnrollmentModel;
use App\Models\StudentModel;
use CodeIgniter\Controller;

class Student extends Controller
{
    public function __construct()
    {
        $session = session();
        if (!$session->get('isLoggedIn') || $session->get('role') != 'student') {
            return redirect()->to(base_url());
        }
    }

    public function index()
    {
        return view('student/dashboard');
    }

    public function courses()
    {
        $session = session();
        $courseModel = new CourseModel();
        $enrollmentModel = new EnrollmentModel();
        $studentModel = new StudentModel();
        
        $userId = $session->get('user_id');
        $student = $studentModel->getStudentWithUser($userId);

        $data['courses'] = $courseModel->findAll();
        $data['enrolledCourses'] = [];
        if ($student) {
            $enrollments = $enrollmentModel->where('student_id', $student['id'])->findAll();
            // Ambil ID mata kuliah yang sudah di-enroll
            foreach ($enrollments as $enrollment) {
                $data['enrolledCourses'][] = $enrollment['course_id'];
            }
        }
        
        return view('student/courses', $data);
    }

    public function enroll()
    {
        $session = session();
        $enrollmentModel = new EnrollmentModel();
        $studentModel = new StudentModel();
        
        $userId = $session->get('user_id');
        $student = $studentModel->getStudentWithUser($userId);
        $courseId = $this->request->getVar('course_id');

        if ($student) {
            // Cek apakah mahasiswa sudah mengambil mata kuliah ini
            $isEnrolled = $enrollmentModel->where('student_id', $student['id'])
                                          ->where('course_id', $courseId)
                                          ->first();
            
            if (!$isEnrolled) {
                $data = [
                    'student_id' => $student['id'],
                    'course_id' => $courseId,
                ];
                $enrollmentModel->insert($data);
                $session->setFlashdata('success', 'Mata kuliah berhasil di-enroll.');
            } else {
                $session->setFlashdata('error', 'Anda sudah mengambil mata kuliah ini.');
            }
        }
        
        return redirect()->to(base_url('student/courses')); // Arahkan ke halaman daftar mata kuliah
    }

    public function enrollments()
    {
        $session = session();
        $enrollmentModel = new EnrollmentModel();
        $studentModel = new StudentModel();
        
        $userId = $session->get('user_id');
        $student = $studentModel->getStudentWithUser($userId);
        
        $data['enrollments'] = [];
        if ($student) {
            $data['enrollments'] = $enrollmentModel->getEnrollmentsByStudentId($student['id']);
        }

        return view('student/enrollments', $data);
    }
}