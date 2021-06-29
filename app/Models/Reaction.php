<?php
// THIS MODEL HAS POLIMORPHYC RELATIONSHIP
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    use HasFactory;
    protected $guarded = ['id']; // block these field
    const LIKE = 1;
    const DISLIKE = 2;


    // Relationshio one to many inverse
    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    //  Relationshio one to one polymorphic
    public function reactionable(){
        return $this->morphTo();
    }



}
