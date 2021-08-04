<?php

use Illuminate\Support\Facades\Route;

// llamando controlador que tiene el crud de instructor
use App\Http\Controllers\Instructor\CourseController;
use App\Http\Livewire\Instructor\CoursesCurriculum;
use App\Http\Livewire\Instructor\CoursesStudents;



// su unicia funcion es llevar a la ruta escrita completamente instructor/courses
Route::redirect('', 'instructor/courses');

// asignar el control de las 7 rutas a un controlador
Route::resource('courses', CourseController::class)->names('courses');


Route::get('courses/{course}/curriculum', CoursesCurriculum::class)->middleware('can:Actualizar cursos')->name('courses.curriculum');

// el control de esta ruta va a ser determinado por un un controlador de livewire

Route::get('courses/{course}/goals', [CourseController::class, 'goals'])->name('courses.goals');

Route::get('courses/{course}/students', CoursesStudents::class)->middleware('can:Actualizar cursos')->name('courses.students');

Route::post('courses/{course}/status', [CourseController::class, 'status'])->name('courses.status');

Route::get('courses/{course}/observation', [CourseController::class, 'observation'])->name('courses.observation');

