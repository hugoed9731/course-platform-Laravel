<?php
// THIS MODEL HAS POLYMORPHIC RELATIONSHIP
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $guarded = ['id']; // block these field
    
    // Relationship one to one polymorphic
    public function commentable(){
        return $this->morphTo();
    }

        // Relationshio one to many inverse
        public function user(){
            return $this->belongsTo('App\Models\User');
        }
    

    // Relationship one to many polymorphic
    public function comments(){
        return $this->morphMany('App\Models\Comment', 'commentable');
    }

    public function reactions(){
        return $this->morphMany('App\Models\Reaction', 'reactionable');
    }
}
