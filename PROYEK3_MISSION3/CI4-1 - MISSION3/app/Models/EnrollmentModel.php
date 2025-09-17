<?php namespace App\Models;

use CodeIgniter\Model;

class EnrollmentModel extends Model {
    protected $table      = 'takes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['student_id','course_id','status'];
    protected $useTimestamps = false;
}
