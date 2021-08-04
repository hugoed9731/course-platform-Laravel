<?php

namespace App\Http\Livewire\Instructor;

use App\Models\Lesson;
use Livewire\Component;

class LessonDescription extends Component
{

    // recibimos la informacion de la leccion
    public  $lesson, $description, $name;

    // sincronizar campos, pero primero traer reglas de validacion

    protected $rules = [
        'description.name' => 'required'
    ];

    public function mount(Lesson $lesson){
        $this->lesson = $lesson; 

        if ($lesson->description) {
            // si la leccion tiene una descripcion se llena con ese valor
            $this->description = $lesson->description;
        }
    }

    public function render()
    {
        return view('livewire.instructor.lesson-description');
    }

    public function store(){
        // agregar un nuevo registro, una nueva descripcion
       $this->description = $this->lesson->description()->create(['name' => $this->name]);
        // agrega un nuevo registro en la tabla description y lo relaciona con el registro lesson

        // resetea lo que tengo almacenado en la propiedad name
        $this->reset('name');

            // actualiza la tabla
            $this->lesson = Lesson::find($this->lesson->id);
    }


    public function update() {
        $this->validate();
        $this->description->save();
    }

    public function destroy() {
        $this->description->delete();

        // reseteamos la propiedad
        $this->reset('description');
        // actualiza la tabla
        $this->lesson = Lesson::find($this->lesson->id);
    }
}
