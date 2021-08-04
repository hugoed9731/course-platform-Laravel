<?php

namespace App\Http\Livewire\Instructor;

use Livewire\Component;
use App\Models\Course;
use Livewire\WithPagination;

class CoursesIndex extends Component
{
    use WithPagination;

    public $search;

    public function render()
    {
        // recuperamos todo el listado de cursos

        $courses = Course::where('title', 'LIKE', '%' . $this->search . '%')
        ->where('user_id', auth()->user()->id)
        ->latest('id')      //ordena de manera descendente por el campo id
        ->paginate(8);
        // ('user_id', auth()->user()->id) - recuperamos el id del usuario autenticado
        return view('livewire.instructor.courses-index', compact('courses'));
    }

    // solucion de paginacion
    public function limpiar_page(){
        $this->reset('page');
    }
}
