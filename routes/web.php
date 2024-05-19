<?php

use App\Http\Controllers\MainController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('login');
Route::get('/register', function () {
    return view('register');
})->name('register');


Route::controller(UserController::class)->group(function () {
    Route::post('/register', 'register')->name('register.user');
    Route::post('/login', 'login')->name('login.user');
});

Route::middleware(['auth'])->group(function () {
    Route::controller(MainController::class)->group(function () {
        Route::get('/homepage', 'homepage')->name('homepage');
        Route::get('/teacher/homepage', 'homepage')->name('teacher.homepage');
        Route::post('/teacher/editProfile', 'editProfile')->name('edit.profile');
        Route::post('/bookTeacher', 'bookTeacher')->name('book.teacher');
        Route::get('/inquiries', 'inquiries')->name('inquiries');
        Route::get('/clients', 'clients')->name('clients');
        Route::delete('/removeClients', 'removeClients')->name('remove.clients');
        Route::patch('/doneClient', 'doneClient')->name('done.clients');
        Route::get('/getTeacher', 'getTeacher')->name('get.teacher');
        Route::get('/getCategoryTeacher', 'getCategoryTeacher')->name('get.teacher.category');
        Route::get('/filterTeachers', 'filterTeachers')->name('filter.teacher');
        Route::post('/editClientProfile', 'editClientProfile')->name('edit.client.profile');
    });

    Route::controller(UserController::class)->group(function () {
        Route::get('/logout', 'logout')->name('logout');
    });
});
