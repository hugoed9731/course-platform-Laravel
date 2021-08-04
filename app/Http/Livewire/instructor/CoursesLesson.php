<?php

namespace App\Http\Livewire\Instructor;

use App\Models\Lesson;
use App\Models\Platform;
use App\Models\Section;
use Livewire\Component;

class CoursesLesson extends Component
{
    public $section, $lesson, $platforms, $name, $platform_id = 1, $url;

    // regla de validación
    protected $rules = [
        'lesson.name' => 'required',
        'lesson.platform_id' => 'required',
        // youtube
        'lesson.url' =>  ['required', 'regex:%^ (?:https?://)? (?:www\.)? (?: youtu\.be/ | youtube\.com (?: /embed/ | /v/ | /watch\?v= ) ) ([\w-]{10,12}) $%x'],
        // vimeo

    ];

    public function mount(Section $section){
        // remplazar rl valor de la propiedad por lo que mandamos por parametro
        $this->section = $section;

        $this->platforms = Platform::all();

        $this->lesson = new Lesson();
    }


    public function render()
    {
        return view('livewire.instructor.courses-lesson');
    }

    public function store() {

        $rules = [
            'name' => 'required',
            'platform_id' => 'required',
            // youtube
            'url' =>  ['required', 'regex:%^ (?:https?://)? (?:www\.)? (?: youtu\.be/ | youtube\.com (?: /embed/ | /v/ | /watch\?v= ) ) ([\w-]{10,12}) $%x'],    
        ];


        if ($this->platform_id == 2) {
            // si ocurre esto queremos acceder
            $rules['url'] = ['required', 'regex:/\/\/(www\.)?vimeo.com\/(\d+)($|\/)/'];
        }

        $this->validate($rules);

        // crear nueva leccion

        Lesson::create([
            'name' => $this->name,
            'platform_id' => $this->platform_id,
            'url' => $this->url,
            'section_id' => $this->section->id
            // relacionar la leccion con su seccion
        ]);

        // formatear los inputs ya que se haya enviado la informacion
        $this->reset([
            'name', 'platform_id', 'url'
        ]);
        // actualizar la informacion en la bd
        $this->section = Section::find($this->section->id);


    }

    public function edit(Lesson $lesson){
        // solucion de error, campo vacio no se quita la alerta de error de los otros cambios
        $this->resetValidation();


        // remplazamos el valor de la propiedad lesson por lo que estamos pasando en parametro
        $this->lesson = $lesson;
    }

    public function update() {
        // valida las reglas
        // segun la plataforma
        if($this->lesson->platform_id == 2){
            $this->rules['lesson.url'] = ['required', 'regex:/\/\/(www\.)?vimeo.com\/(\d+)($|\/)/'];
        }

        $this->validate();


        // despues de validar mandar los cambios a la bd

        $this->lesson->save();
        // limpiamos los datos
        $this->lesson = new Lesson();

        // actualizamos en la bd
        // los id deben de coincidir para realizar cualquier cambio
        $this->section = Section::find($this->section->id);
    }

    public function destroy(Lesson $lesson){
        $lesson->delete();

        // refresca la informacion de la leccion
        $this->section = Section::find($this->section->id);

    }

    public function cancel(){
        // limpía la información
        $this->lesson = new Lesson();
    }
}
