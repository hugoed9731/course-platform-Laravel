<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Course;

use App\Models\Category;
use App\Models\Level;
use Livewire\WithPagination;


class CourseIndex extends Component
{
    use WithPagination; // con esto logramos que la paginacion no se recarge
    public $category_id;
    public $level_id;


    public function render()
    {
        $categories = Category::all();
        $levels = Level::all();


        // muestro los que tiene status 3 y los ordene de manera descendente de acuerdo al id - que lo muestre paginado de 8 en 8
        $courses = Course::where('status', 3)
        ->category($this->category_id) // filtra los category_id que coincidad con la $category_id
        ->level($this->level_id)
        ->latest('id')
        ->paginate(8);
        return view('livewire.course-index', compact('courses', 'categories', 'levels'));// aqui le pasamos lo recuperado de los models a view
    }


    // método para el boton de todos los cursos

    public function resetFilters(){
        $this->reset(['category_id', 'level_id']);
    }
}
