<?php namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CourseModel;

class CourseController extends BaseController {
    public function index() {
        $courseModel = new CourseModel();
        $data['courses'] = $courseModel->findAll();
        return view('admin/courses/index',$data);
    }

    public function create() {
        $courseModel = new CourseModel();
        $courseModel->insert([
            'course_code' => $this->request->getPost('course_code'),
            'course_name' => $this->request->getPost('course_name'),
            'credits'     => $this->request->getPost('credits'),
        ]);
        return redirect()->back()->with('success','Course added');
    }

    public function delete($id) {
        $courseModel = new CourseModel();
        $courseModel->delete($id);
        return redirect()->back()->with('success','Course deleted');
    }
}
