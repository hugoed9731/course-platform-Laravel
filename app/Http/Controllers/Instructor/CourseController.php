<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

use App\Models\Course;
use App\Models\Level;
use App\Models\Price;

// este paquete es para enviar a otra carpeta la imagen y no se quede en temporal
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{

    public function __construct()
    {
        // middleware para las rutas
        $this->middleware('can:Leer cursos')->only('index'); //especificamos que solo queremos que protega al metodos index
        $this->middleware('can:Crear cursos')->only('create', 'store'); 
        $this->middleware('can:Actualizar cursos')->only('edit', 'update', 'goals'); 
        $this->middleware('can:Eliminar cursos')->only('edit', 'destroy'); 
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('instructor.courses.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
    
        $categories = Category::pluck('name', 'id');
        $levels = Level::pluck('name', 'id');
        $prices = Price::pluck('name', 'id');
        return view('instructor.courses.create', compact('categories', 'levels', 'prices'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // desde aquí se manda la informacion de un nuevo curso

        $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:courses',
            'subtitle' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'level_id' => 'required',
            'price_id' => 'required',
            'file' => 'image'

        ]);

        // crear nuevo registro de cursos
        $course = Course::create($request->all());

        // verificamos si estamos enviando una imagen
        if($request->file('file')) {
          $url = Storage::put('courses', $request->file('file'));
        //   una vez que esto mueva la img a la carpeta que queremos, almacena la url en $

        /*
         // creas un nuevo registro en la table img y se relaciona con lo que hemos creado arriba
        */
        $course->image()->create([
            'url' => $url
        ]);
        } 

        return redirect()->route('instructor.courses.edit', $course);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        return view('instructor.courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        $this->authorize('dicatated', $course);

        $categories = Category::pluck('name', 'id'); //rescatamos todos los registros de categoriaa
        // pluck - nos crea una coleccion - el indice se trata del campo id
        // esto con el fin de usar laravel connective y poder usar el desplegable
        $levels = Level::pluck('name', 'id');
        $prices = Price::pluck('name', 'id');

        return view('instructor.courses.edit', compact('course', 'categories', 'levels', 'prices'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Course $course)
    {

        $this->authorize('dicatated', $course);


        $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:courses,slug,' . $course->id, // le decimos que ignore el id del slug
            'subtitle' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'level_id' => 'required',
            'price_id' => 'required',
            'file' => 'image'
        ]);


        $course->update($request->all());
        // Actualizacion de img
        if($request->file('file')){
            $url = Storage::put('courses', $request->file('file'));

            // si existe alguna imagen asociada a ese curso
            if ($course->image) {
                Storage::delete([$course->image->url]);
                // aqui se actualiza la imagen se realiza la accion
                $course->image->update([
                    'url' => $url // url donde se esta almacenada la nueva imagen que hemos subido
                ]);
            } else {
                //si no tiene ninguna imagen asociada crea u nuevo registro en image y se asocie a este curso
                $course->image()->create([
                    'url' => $url
                ]);
            }
        }


        return redirect()->route('instructor.courses.edit', $course);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        //
    }

    public function goals(Course $course) {
        $this->authorize('dicatated', $course);

        return view('instructor.courses.goals', compact('course'));
    }

    public function status(Course $course){
        $course->status = 2;
        // guardar en la bd
        $course->save();
        // retorname a la pagina anterior

        // recuperamos el registro de la observacion, y una ve recuperado lo elimina
        if ($course->observation) {
            $course->observation->delete();
        }
        return redirect()->route('instructor.courses.edit', $course);
    }

    public function observation(Course $course) {
        return view('instructor.courses.observation', compact('course'));
    }
  
}