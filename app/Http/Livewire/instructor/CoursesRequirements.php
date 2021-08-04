<?php

namespace App\Http\Livewire\Instructor;

use App\Models\Course;
use App\Models\Requirement;
use Livewire\Component;

class CoursesRequirements extends Component
{

    // primero recibimos la informacion que estamos enviando por parametro
    public $course, $requirement, $name;

    protected $rules = [
        'requirement.name' => 'required'
    ];

    public function mount(Course $course){
        $this->course = $course;
        $this->requirement = new Requirement();
    }

    public function render()
    {
        return view('livewire.instructor.courses-requirements');
    }

  

    public function store(){
        // reglas de validacion
        $this->validate([
            'name' => 'required'
        ]);
        // crear un nuevo registro de goal
        $this->course->requirements()->create([
            'name' => $this->name
        ]); // agrega la informacion

        // una vez que ha agregado la informacion, que resetee
        $this->reset('name');
        // actualiza la informacion del curso
        $this->course = Course::find($this->course->id); 


    }

    public function edit(Requirement $requirement){
        $this->requirement = $requirement;
    }

    public function update(){
        $this->validate();

        // actualizar la informacion en la bd
        $this->requirement->save();

        // borramos la informacion y le decimos que se trata de una nueva instancia
        $this->requirement = new Requirement();

        $this->course = Course::find($this->course->id); 

    }

    public function destroy(Requirement $requirement){
        $requirement->delete();
            // pedimos que se actualice la informacion del curso
        $this->course = Course::find($this->course->id); 

    }
}

