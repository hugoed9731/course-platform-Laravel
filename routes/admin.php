<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\LevelController;
use App\Http\Controllers\Admin\PriceController;

Route::get('', [HomeController::class, 'index'])->middleware('can:Ver dashboard')->name('home');
// ->middleware('can:Ver dashboard') - proteccion de ruta con los roles asignados


Route::resource('roles', RoleController::class)->names('roles');
// generamos las 7 rutas necesarias para realizar un crud

// Esta ruta es para el CRUD de users de rol, dentro del adminlte
Route::resource('users', UserController::class)->only(['index', 'edit', 'update'])->names('users');
// only(['index', 'edit', 'update']) - especificamos que solo quereremos esos metodos en el crud

Route::resource('categories', CategoryController::class)->names('categories');

Route::resource('levels', LevelController::class)->names('levels');

Route::resource('prices', PriceController::class)->names('prices');

Route::get('courses', [CourseController::class, 'index'])->name('courses.index');

Route::get('courses/{course}', [CourseController::class, 'show'])->name('courses.show');


Route::post('courses/{course}/approved', [CourseController::class, 'approved'])->name('courses.approved');


Route::get('courses/{course}/observation', [CourseController::class, 'observation'])->name('courses.observation');

Route::post('courses/{course}/reject', [CourseController::class, 'reject'])->name('courses.reject');
