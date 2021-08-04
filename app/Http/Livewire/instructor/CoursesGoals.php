<?php

namespace App\Http\Livewire\Instructor;

use App\Models\Course;
use App\Models\Goal;
use Livewire\Component;

class CoursesGoals extends Component
{

    // primero recibimos la informacion que estamos enviando por parametro
    public $course, $goal, $name;

    protected $rules = [
        'goal.name' => 'required'
    ];

    public function mount(Course $course){
        $this->course = $course;
        $this->goal = new Goal();
    }

    public function render()
    {
        return view('livewire.instructor.courses-goals');
    }

    public function store(){
        // reglas de validacion
        $this->validate([
            'name' => 'required'
        ]);
        // crear un nuevo registro de goal
        $this->course->goals()->create([
            'name' => $this->name
        ]); // agrega la informacion

        // una vez que ha agregado la informacion, que resetee
        $this->reset('name');
        // actualiza la informacion del curso
        $this->course = Course::find($this->course->id); 


    }

    public function edit(Goal $goal){
        $this->goal = $goal;
    }

    public function update(){
        $this->validate();

        // actualizar la informacion en la bd
        $this->goal->save();

        // borramos la informacion y le decimos que se trata de una nueva instancia
        $this->goal = new Goal();

        $this->course = Course::find($this->course->id); 

    }

    public function destroy(Goal $goal){
        $goal->delete();
            // pedimos que se actualice la informacion del curso
        $this->course = Course::find($this->course->id); 

    }
}
