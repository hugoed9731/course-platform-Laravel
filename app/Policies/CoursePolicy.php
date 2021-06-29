<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Course;
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
}
