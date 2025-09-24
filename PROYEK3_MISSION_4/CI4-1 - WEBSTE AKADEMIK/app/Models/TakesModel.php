<?php
namespace App\Models;

use CodeIgniter\Model;

class TakesModel extends Model
{
    protected $table = 'enrollments';
    protected $primaryKey = 'id';
    protected $allowedFields = ['student_id', 'course_id'];
}
