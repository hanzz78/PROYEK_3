<?php namespace App\Controllers\Student;

use App\Controllers\BaseController;
use App\Models\CourseModel;
use App\Models\EnrollmentModel;

class CourseController extends BaseController {

    public function index() {
        $courseModel = new CourseModel();
        $enrollModel = new EnrollmentModel();

        $userId = session()->get('user_id');
        if (!$userId) return redirect()->to('/login');

        // semua course
        $data['courses'] = $courseModel->findAll();

        // course yang sudah diambil student
        $enrolled = $enrollModel->where('student_id', $userId)->findAll();
        $enrolledIds = array_column($enrolled, 'course_id');

        // hitung total course & sks
        $totalEnrolled = count($enrolledIds);
        $totalCredits = 0;
        if (!empty($enrolledIds)) {
            $coursesTaken = $courseModel->whereIn('course_id', $enrolledIds)->findAll();
            foreach ($coursesTaken as $c) {
                $totalCredits += (int)$c['credits'];
            }
        }

        $data['enrolledIds']   = $enrolledIds;
        $data['totalEnrolled'] = $totalEnrolled;
        $data['totalCredits']  = $totalCredits;

        return view('student/courses/index', $data);
    }

    public function enroll($courseCode) {
        $courseModel = new CourseModel();
        $enrollModel = new EnrollmentModel();

        $userId = session()->get('user_id');
        if (!$userId) return redirect()->to('/login');

        // cari course berdasarkan kode
        $course = $courseModel->where('course_code', $courseCode)->first();
        if (!$course) {
            return redirect()->back()->with('error', 'Course not found');
        }

        // cek apakah sudah diambil
        $exists = $enrollModel->where([
            'student_id' => $userId,
            'course_id'  => $course['course_id']
        ])->first();

        if (!$exists) {
            $enrollModel->insert([
                'student_id' => $userId,
                'course_id'  => $course['course_id'],
                'status'     => 'enrolled'
            ]);
        }

        return redirect()->back()->with('success', 'Enrolled');
    }
}
