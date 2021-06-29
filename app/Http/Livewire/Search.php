<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Course;

class Search extends Component
{

    public $search;
   

    public function render()
    {
        return view('livewire.search');
    }

     // usaremos propiedades computadas - a estas propiedades se les puede dar mayor logica
    public function getResultsProperty(){
        return Course::where('title', 'LIKE', '%' . $this->search . '%')->where('status', 3)->take(8)->get();
        // % - indica que puede haber texto antes o texto despues
        // take limita la cantidad de resultados
        //  )->where('status', 3) filtramos de acuerdo al status en el que se ecuentre ese curso
    }
}
