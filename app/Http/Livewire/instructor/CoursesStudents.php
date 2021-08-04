<?php

namespace App\Http\Livewire\Instructor;

use App\Models\Course;
use Livewire\Component;
use Livewire\WithPagination;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class CoursesStudents extends Component
{
    use WithPagination;

    use AuthorizesRequests;


    public $course, $search;
    public function mount(Course $course){
        $this->course = $course; // ese valor va a ser llenado por la que mandamos por la url

        $this->authorize('dicatated', $course);


    }

    // restrablecer paginacion a la pagina 1 con ciclo de vida livewire

    public function updatingSearch(){
        // se va activar cuando modifiquemos la inf de $search
        $this->resetPage();
    }

    public function render()
    {
        $students = $this->course->students()->where('name', 'LIKE', '%' . $this->search . '%')->paginate(4);

        return view('livewire.instructor.courses-students', compact('students'))->layout('layouts.instructor', ['course' => $this->course]);
    }
}
