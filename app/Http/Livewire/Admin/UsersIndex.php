<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\User;

// paginación de livewire
use Livewire\WithPagination;

class UsersIndex extends Component
{
    
    use WithPagination;
    
    protected $paginationTheme = "bootstrap"; // con esto podemos usar bootstrap en vez de livewire en livewire
    public $search;
   
    public function render()
    {

        // recuperar todo el listado de usuarios % algo atras o adelante de la busqueda
        $users = User::where('name', 'LIKE', '%' . $this->search . '%')
        ->orWhere('email', 'LIKE', '%' . $this->search . '%')
        ->paginate(8);


        return view('livewire.admin.users-index', compact('users'));
    }

    public function limpiar_page(){
        $this->reset('page');
    }
}
