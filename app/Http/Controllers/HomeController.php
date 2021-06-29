<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;


class HomeController extends Controller
{
    // este controlador, solo va administrar una unica ruta

    public function __invoke()
    {
        // latest- ordenar los registros que recupere en forma descendente
        $courses = Course::where('status', '3')->latest('id')->get()->take(12);  //queremos recuperar todos los cursos subido
    //    con take le indicamos que solo queremos que recupere 12 registros en nuestra vista
        return view('welcome', compact('courses')); // de esta manera pasamos la coleccion a la vista welcome 
        // compact busca una variable con ese nombre en la tabla
    }   
}
