<?php

namespace App\Http\Livewire\Instructor;

use Livewire\Component;
use App\Models\Course;
use App\Models\Section;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CoursesCurriculum extends Component
{

    use AuthorizesRequests;
    public $course, $section, $name;

    protected $rules = [
        'section.name' => 'required'
    ];


    public function mount(Course $course){
        $this->course = $course;
        $this->section = new Section();

        $this->authorize('dicatated', $course);
    }

    public function render()
    {
        return view('livewire.instructor.courses-curriculum')->layout('layouts.instructor', ['course' => $this->course]);
    }

    public function store() {

        $this->validate([
            // especificamos el campo a validar
            'name' => 'required'
        ]);

        // nuevo registro en secciones
        Section::create([
            'name' => $this->name,
            'course_id' => $this->course->id
        ]);

        // despues de crear el registro quiero que me resetees el valor de la propiedad name
        $this->reset('name');

        // refresca la informacion del curso
        $this->course = Course::find($this->course->id);
    }


    public function edit(Section $section){
        $this->section = $section; // remplazamos el valor de seccion por lo que le mandamos en la $
    }


    public function update(){

        $this->validate();

        $this->section->save();
        // ya que se han guardado los cambios debemos que limpirar lo que hay en section
        $this->section = new Section();

        // volver a hacer la consulta para que la pagina se vean los cambios sin hacer refresh
        $this->course = Course::find($this->course->id);
    }


    public function destroy(Section $section){
        $section->delete();

        // refresca la informacion 
        $this->course = Course::find($this->course->id);

    }
}
