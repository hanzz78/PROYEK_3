<?php

namespace App\Models;
use CodeIgniter\Model;

class MahasiswaModel extends Model
{
    protected $table = 'mahasiswa';

    // fungsi untuk ambil data dengan query mentah
    public function getMahasiswa()
    {
        $db = \Config\Database::connect();
        $query = $db->query("SELECT * FROM mahasiswa");
        return $query->getResultArray(); // kembalikan segaa=la array
    }
}