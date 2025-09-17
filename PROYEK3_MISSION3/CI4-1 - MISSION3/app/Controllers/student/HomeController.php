<?php namespace App\Controllers\Student;

use App\Controllers\BaseController;

class HomeController extends BaseController {
    public function index() {
        return view('student/home');
    }
}
