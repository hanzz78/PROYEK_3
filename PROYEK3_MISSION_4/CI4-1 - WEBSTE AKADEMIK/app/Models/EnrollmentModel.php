<?php namespace App\Models;

use CodeIgniter\Model;

class EnrollmentModel extends Model
{
    protected $table = 'enrollments';
    protected $primaryKey = 'id';
    protected $allowedFields = ['student_id', 'course_id', 'created_at'];

    // Method untuk mendapatkan data enrollment beserta data course
    public function getEnrollmentsByStudentId($studentId)
    {
        return $this->join('courses', 'courses.id = enrollments.course_id')
                    ->where('enrollments.student_id', $studentId)
                    ->findAll();
    }
}