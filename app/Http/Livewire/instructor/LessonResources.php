<?php

namespace App\Http\Livewire\Instructor;

use App\Models\Lesson;

use Livewire\Component;

use Illuminate\Support\Facades\Storage;

// este componente permite imporar imagenes al servidor
use Livewire\WithFileUploads;

class LessonResources extends Component
{

    use WithFileUploads;
    // esta clase sirve para que livewire pueda procesar imagenes
    public $lesson, $file;

    public function mount(Lesson $lesson){
        $this->lesson = $lesson;
        // llenalo con la informacion que estamos mandando desde el parametro - course.lesson.blade
    }

    public function render()
    {
        return view('livewire.instructor.lesson-resources');
    }

    public function save() {
        // valida si se ha seleccionado algun archivo
        $this->validate([
            'file' => 'required'
        ]);

        // mover archivos a una carpeta en particular
        $url = $this->file->store('resources');
        $this->lesson->resource()->create([
            'url' => $url
        ]);
        // almacenar la url de la imgtemp en resurces relacionarlo con el registro almacenado en la $lesson

        // ya teniendo la url con la relacion - actualiza la leccion en la bd
        $this->lesson = Lesson::find($this->lesson->id);
    }
    public function destroy(){
        Storage::delete($this->lesson->resource->url);
        // elimina la img de la carpeta, la eliminadmos de la bd
        $this->lesson->resource->delete();
        // refrescar la informacion de la leccion

        $this->lesson = Lesson::find($this->lesson->id);

    }
    public function download() {
        // descargar files con livewire
        return response()->download(storage_path('app/public/' . $this->lesson->resource->url));
        // storage_path - nos devuelve la ruta hasta storage
    }
}