<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Default ke login
$routes->get('/', 'Auth::loginForm');

$routes->get('/', 'Auth::loginForm');
$routes->get('login', 'Auth::loginForm');
$routes->post('login', 'Auth::login');
$routes->get('register', 'Auth::registerForm');
$routes->post('register', 'Auth::register');
$routes->get('logout', 'Auth::logout');

// Admin
$routes->group('admin',['filter'=>'role:admin'], function($routes){
    $routes->get('home','Admin\HomeController::index');
    $routes->get('courses','Admin\CourseController::index');
    $routes->post('courses/create','Admin\CourseController::create');
    $routes->post('courses/(:num)/delete','Admin\CourseController::delete/$1');
});

// Student
$routes->group('student',['filter'=>'role:student'], function($routes){
    $routes->get('home','Student\HomeController::index');
    $routes->get('courses','Student\CourseController::index');
    $routes->post('courses/(:segment)/enroll','Student\CourseController::enroll/$1');
});
    



