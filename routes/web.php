<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CourseController;
use App\Http\Livewire\CourseStatus;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', HomeController::class)->name('home');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// ruta para el boton catalogo de cursos
Route::get('cursos', [CourseController::class, 'index'])->name('courses.index');
// le asignamos el control de esta ruta al controlador

Route::get('cursos/{course}', [CourseController::class, 'show'])->name('courses.show');
// esta ruta va a ser administrada por el controlador CourseController - por el método show

// Ruta para matricular a un determinado usuario
Route::post('courses/{course}/enrolled',[CourseController::class, 'enrolled'])->middleware('auth')->name('courses.enrolled'); //solo las personas matriculadas van a poder matricularse a un curso


// Ruta que te manda al curso que se ha seleccionada
Route::get('course-status/{course}', CourseStatus::class)->name('courses.status')->middleware(('auth'));
// le asignamos el control de la ruta a componente de livewire
