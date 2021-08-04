<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Course;
use App\Models\Review;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoursePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    // este método verifica si un alumno esta matriculado o no lo esta
    // esta función recibe dos parametros
    public function enrolled(User $user, Course $course){
        // lo que buscamos es que cuando se ejecute esta lógica nos devuelva true o false

    // recuperar todos los registros de los usuarios que se han matriculado a este curso
    // students - es la relacion de muchos a muchos course - se accede al registro del curso
    return $course->students->contains($user->id); 
    //contains - verifica si uno de ellos corresponde a la esta coleccion $course->students

    }



    public function published(?User $user,  Course $course) {
        // ? - puede o no el usuario estar autentificao y mostrara los cursos status 3 solamente
        if ($course->status == 3) {
            return true;
        }else {
            return false;
        }
    }

    // instructores verificar que el usuario quiere verificar un curso ha creado ese curso
    public function dicatated(User $user, Course $course){
        if($course->user_id == $user->id){
            return true;
        } else {
            return false;
        }
    }

    public function revision(User $user, Course $course){
        if ($course->status == 2) {
            return true;
        } else {
            return false;
        }
    }

    // evitar que el usuario mande más de una valoración
    public function valued(User $user, Course $course) {
        if (Review::where('user_id', $user->id)->where('course_id', $course->id)->count()) {
            return false;
        } else {
            return true;
        }
    }
}
