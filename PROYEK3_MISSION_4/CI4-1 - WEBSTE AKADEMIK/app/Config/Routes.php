<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', function() {
    return redirect()->to(base_url('index.html'));
});

$routes->group('api', function($routes) {
    // Auth
    $routes->post('login', 'Api::login');

    // Admin
    $routes->get('admin/courses', 'Api::getAdminCourses');
    $routes->post('admin/courses/store', 'Api::createAdminCourse');
    $routes->delete('admin/courses/delete/(:num)', 'Api::deleteAdminCourse/$1');
    $routes->get('admin/students', 'Api::getAdminStudents');
    $routes->get('admin/students/(:num)', 'Api::getStudentData/$1'); // Tambah rute untuk ambil 1 data mahasiswa
    $routes->post('admin/students/store', 'Api::createAdminStudent');
    $routes->put('admin/students/update/(:num)', 'Api::updateAdminStudent/$1');
    $routes->delete('admin/students/delete/(:num)', 'Api::deleteAdminStudent/$1');

    // Student
    $routes->get('student/courses', 'Api::getStudentCourses');
    $routes->get('student/enrollments', 'Api::getStudentEnrollments');
    $routes->post('student/enroll', 'Api::enrollStudentCourses');
    
    // Courses endpoint untuk student enrollment detail
    $routes->get('courses/(:num)', 'Api::getCourseDetail/$1');
});