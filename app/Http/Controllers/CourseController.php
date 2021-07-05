<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
    public function index(){    // asignamos el control de la url cursos a este método
        return view('courses.index');
    }

    public function show(Course $course){ // actualmente se esta enviando un parametro por la URL


        $this->authorize('published', $course); // segundo es el objeto $course, verifica la informacion

        // CINCO CURSOS SIMILARES AL CUAL SE LE ESTA HACIENDO LA CONSULTA
        // recuperar el registro de los cursos similares, al curso que se esta visitando
        $similares = Course::where('category_id', $course->category_id)
        ->where('id', '!=', $course->id)   // regresa los registros que sean diferentes a este curso
        ->where('status', 3) // que nos devuelva los cursos que te esten publicados
        ->latest('id') // ordena al campo id de manera descendente
        ->take(5)
        ->get();
 
        // Course $course - es una instancia del modelo course
        return view('courses.show', compact('course', 'similares'));
    }

                // los datos de los usuarios matriculados, iran a una tabla intermedia en especifico

    // vamos a enviar una variable por la url
        public function enrolled(Course $course){
            // verificamos que todo este funcionando ok
            $course->students()->attach(auth()->user()->id);
            // auth()->user() - recuperamos el id de usuario actualmente autentificado
            // aqui recuperamos la relacion muchos a muchos de students
            // Attach sirve para agregar relaciones muchos a muchos - from google

            return redirect()->route('courses.status', $course);
        }



     
}
