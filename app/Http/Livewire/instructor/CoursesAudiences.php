<?php

namespace App\Http\Livewire\Instructor;

use App\Models\Audience;
use App\Models\Course;
use Livewire\Component;

class CoursesAudiences extends Component
{

      // primero recibimos la informacion que estamos enviando por parametro
      public $course, $audience, $name;

      protected $rules = [
          'audience.name' => 'required'
      ];
  
      public function mount(Course $course){
          $this->course = $course;
          $this->audience = new Audience();
      }

    public function render()
    {
        return view('livewire.instructor.courses-audiences');
    }


    public function store(){
        // reglas de validacion
        $this->validate([
            'name' => 'required'
        ]);
        // crear un nuevo registro de goal
        $this->course->audiences()->create([
            'name' => $this->name
        ]); // agrega la informacion

        // una vez que ha agregado la informacion, que resetee
        $this->reset('name');
        // actualiza la informacion del curso
        $this->course = Course::find($this->course->id); 


    }

    public function edit(Audience $audience){
        $this->audience = $audience;
    }

    public function update(){
        $this->validate();

        // actualizar la informacion en la bd
        $this->audience->save();

        // borramos la informacion y le decimos que se trata de una nueva instancia
        $this->audience = new Audience();

        $this->course = Course::find($this->course->id); 

    }

    public function destroy(Audience $audience){
        $audience->delete();
            // pedimos que se actualice la informacion del curso
        $this->course = Course::find($this->course->id); 

    }
}


