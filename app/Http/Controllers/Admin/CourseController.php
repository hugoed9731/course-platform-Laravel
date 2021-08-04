<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;

use Illuminate\Support\Facades\Mail;
use App\Mail\ApprovedCourse;
use App\Mail\RejectCourse;

class CourseController extends Controller
{
    public function index(){

        $courses = Course::where('status', 2)->paginate();

        return view('admin.courses.index', compact('courses'));
    }



    public function show(Course $course){
        $this->authorize('revision', $course);
        // verifica el metodo revision que es un policie

        return view('admin.courses.show', compact('course'));
    }

    public function approved(Course $course){
        $this->authorize('revision', $course);
        // verifica el metodo revision que es un policie

        if(!$course->lessons || !$course->goals || !$course->requirements || !$course->image){
            // si este curso tiene lecciones asociadas es true, con la ! da false
            return back()->with('info', 'No se puede publicar un curso que no este completo');
        }

        $course->status = 3;
        // ya que se cambio el status - guardarlo en la bd
        $course->save();

        // Enviar el correo electronico
        // creamos nueva instancia de approvedcourse
        $mail = new ApprovedCourse($course);
        //  en la variable $course se almacena la informacion como title

        // le indicamos que lo ponga en una cola de trabajo para agilizar el proceso
        Mail::to($course->teacher->email)->queue($mail);
        // ejecutar esto en consola para enviar el correo php artisan queue:work
        return redirect()->route('admin.courses.index')->with('info', 'El curso se publico con éxito');
    }

    public function observation(Course $course){
        return view('admin.courses.observation', compact('course'));
    }

    public function reject(Request $request, Course $course){

        $request->validate([
            'body' => 'required'
        ]);

        $course->observation()->create($request->all());
        // accedemos a la relacion observation que es cursos con observaciones
        // se crea una nueva id, pero lo completa con la id que viene en $course

        $course->status = 1;
        // ya que se cambio el status - guardarlo en la bd
        $course->save();

         // Enviar el correo electronico
        // creamos nueva instancia de approvedcourse
        $mail = new RejectCourse($course);
        //  en la variable $course se almacena la informacion como title

        // le indicamos que lo ponga en una cola de trabajo para agilizar el proceso
        Mail::to($course->teacher->email)->queue($mail);
        // ejecutar esto en consola para enviar el correo php artisan queue:work
        return redirect()->route('admin.courses.index')->with('info', 'El curso se ha rechazado');

    }
}
