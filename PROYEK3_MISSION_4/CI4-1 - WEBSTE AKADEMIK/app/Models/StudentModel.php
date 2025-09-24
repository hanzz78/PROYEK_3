<?php namespace App\Models;

use CodeIgniter\Model;

class StudentModel extends Model
{
    protected $table = 'students';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nim', 'nama_lengkap', 'umur', 'user_id', 'created_at'];

    // Method untuk mendapatkan data student beserta data user-nya
    public function getStudentWithUser($userId)
    {
        return $this->where('user_id', $userId)->first();
    }
}