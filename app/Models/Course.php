<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'status']; // block these field
    protected $withCount = ['students', 'reviews']; // determina cuantos estudiantes existen

    // we definie constants to use them in the migrations   
     const BORRADOR = 1;
     const REVISION = 2;
     const PUBLICADO = 3;


    //  agregar un nuevo atributo
    public function getRatingAttribute(){
        // si tiene calificaciones ...
        if ($this->reviews_count) {
               // retornar los reviews que han dejado los alumnos
        return round($this->reviews->avg('rating'), 1); // estamos retornando la relacion, la coleccion
        //  round nos redondea, 1 la cantidad de decimales que queremos
        // obtener promedio de todas las calificaciones que han dejado acerca de este curso
        } else{
            return 5;
        }
    }

    // Query Scopes

    public function scopeCategory($query, $category_id){
        // este método si o si debe recibir la variable $query
        // si hay algo almacenado aquí, quiero que se realice una consulta
        if($category_id){
            return $query->where('category_id', $category_id);
        }
    }

    public function scopeLevel($query, $level_id){
        // este método si o si debe recibir la variable $query
        // si hay algo almacenado aquí, quiero que se realice una consulta
        if($level_id){
            return $query->where('level_id', $level_id);
        }
    }

    // metodo para que en la url no de id si no el slug nombre del curso, osea url amigable
    public function getRouteKeyName()
    {
        return "slug";
    }

    // Relación uno a uno
    public function observation(){
        return $this->hasOne('App\Models\Observation');
    }

    // Relationships one to many
    // Relationship to review one to many
      public function reviews(){
        return $this->hasMany('App\Models\Review');
    }
    // Relationships to requirement,goal,audience, section
        public function requirements(){
            return $this->hasMany('App\Models\Requirement');
        }
        public function goals(){
            return $this->hasMany('App\Models\Goal');
        }
        public function audiences(){
            return $this->hasMany('App\Models\Audience');
        }
        public function sections(){
            return $this->hasMany('App\Models\Section');
        }
    // ==================================================
     // Relationship one to many reverse

     public function teacher(){
         return $this->belongsTo('App\Models\User', 'user_id'); // we specify that the foreign key is  user id
     }
    //  relationships with level, category, price one to many reverse
        public function level(){
            return $this->belongsTo('App\Models\Level');
        }
        public function category(){
            return $this->belongsTo('App\Models\Category');
        }
        public function price(){
            return $this->belongsTo('App\Models\Price');
        }
     // Relationship many to many 
     
     public function students(){
        return $this->belongsToMany('App\Models\User');
    }

    // Relationship one to one polymorphic
    public function image(){
        return $this->morphOne('App\Models\Image', 'Imageable');
    }
    // Relationship courses with lesson with intermediate table
    public function lessons(){
        return $this->hasManyThrough('App\Models\Lesson', 'App\Models\Section');
    }
}
