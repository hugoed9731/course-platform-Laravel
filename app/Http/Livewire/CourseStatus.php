<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Course;
use App\Models\Lesson;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CourseStatus extends Component
{

    use AuthorizesRequests;
    public $course, $current;

    public function mount(Course $course) {
        // aqui recibimos lo que estamos pasando por la url
        // asignamos el valor de la variable a la propiedad
        $this->course = $course;


        foreach ($course->lessons as $lesson) {
            if(!$lesson->completed){ // cuando el objeto completed sea falso
                // ejecuta una accion cuando una leccion no este marcada como completa

                // asignale a la propiepad current, el valor de la leccion que no se ha completado
                $this->current = $lesson;

                // una vez que haya completado esta leccion salga del bucle
                break;
            }
        }

        // curso 100% completado
        if (!$this->current) {
            // si no tiene nada asignado, le agregues la ultima leccion del curso
            $this->current = $course->lessons->last();
        }

        // proteger rutas
        // nombre del metodo que verifica una condicion - 2do el objeto que quiero que verifique
        $this->authorize('enrolled', $course);
        
    }

    

    public function render()
    {
        return view('livewire.course-status');
    }

    // Métodos

    // método para al dar clic en otra leccion nos redireccione ahí
    public function changeLesson(Lesson $lesson){
        // este método va a remplazar el valor de la propiedad current - por lo que le estamos mandando por para
      return $this->current = $lesson;
    }


    public function completed(){
        if($this->current->completed){
            // si la unidad actual se ha marcado como completa, se da click de nuevo que elime en bd
            // users() - relación users - detach() - elimina
            $this->current->users()->detach(auth()->user()->id);
        }else{
            // si no esta marcada como culminanda .. Agregar registro - attach - agrega un registro
            $this->current->users()->attach(auth()->user()->id);
        }

        $this->current = Lesson::find($this->current->id);
        // con esto se actualizaria la informacion de cursos
        $this->course = Course::find($this->course->id);
        // recuperamos la misma leccion, pero ahora sabra que ha sido culminada
    }


    // Propiedades computadas
    // nos permite definir propiedades que surgen de procesos sobre otras propiedades. Las propiedades computadas son realmente métodos.
    public function getIndexProperty(){
        return $this->course->lessons->pluck('id')->search($this->current->id); 
        // le indicamos que nos devuelva el indice de la leccion actual
    }


    public function getPreviousProperty(){

        if ($this->index == 0) {
            return null;
        } else {
            return $this->course->lessons[$this->index - 1];
            // la leccion con el index interior con el indice actual
        }
        
    }

    public function getNextProperty(){
        if ($this->index == $this->course->lessons->count() -1) {
            // si el index es igual a la cantidad de registros que tiene esta coleccion
           return  null;
        } else {
            return $this->course->lessons[$this->index + 1];
        }
        // index  se remplace por la informacion que le estamos mandando por parametro
        // ->search($lesson->id - devuelve el indice que coincida con el id de esta leccion
        // el método pluck, crea una coleccion a travez de una coleccion ya existente, solo id aquí
    }

    // agregar propiedad computada para la barra de carga de avance de cursos

    public function getAdvanceProperty(){
        // cuantas lecciones a culminado este usuario
        $i = 0;

        foreach ($this->course->lessons as $lesson) {
            // si el usuario marca a esta unidad como culminada, ingresa a este if
            if ($lesson->completed) {
                $i++; // cada que ingresa la variable aumenta en la unidad i
            }
        }
            // calcular porcentaje
            // accedemos al porcentaje de lecciones culiminadas, por cien entre ($this->course->lessons->count
            $advance = ($i * 100)/($this->course->lessons->count());

            return round($advance, 2); // redondeamos e indicamos que solo tenga dos decimales
       

}

}