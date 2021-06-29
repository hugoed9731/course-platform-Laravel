<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;
    protected $guarded = ['id']; // block these field

        // Relationship one to many
        public function courses(){
            return $this->hasMany('App\Models\Courses');
        }
}
