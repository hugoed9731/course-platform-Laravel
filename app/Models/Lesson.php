<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;
    protected $guarded = ['id']; // block these field

    public function getCompletedAttribute(){
        // La lógica de este atributo es verificar que usuario a dejado como culminada la leccion, recuperar
       return  $this->users->contains(auth()->user()->id);
        // nos recupera el registro de los que han marcado una lession como culminada
    }

    // Relationship one to one
    public function description(){
        return $this->hasOne('App\Models\Description');
    }
       
      // Relationships one to many inverse
      public function section(){
        return $this->belongsTo('App\Models\Section');
    }

    public function platform(){
        return $this->belongsTo('App\Models\Platform');
    }

    // Relationship many to many

    public function users(){
        return $this->belongsToMany('App\Models\User');
    }


    // Relationship one to one polymorphic
    public function resource(){
        return $this->morphOne('App\Models\Resource', 'resourceable');
        // we put the name that we put in the methor to clarfy that is a polymorphic
    }

     // Relationship one to many polymorphic
     public function comments(){
         return $this->morphMany('App\Models\Comment', 'commentable');
     }

     public function reactions(){
        return $this->morphMany('App\Models\Reaction', 'reactionable');
     }
}
