<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    use HasFactory;
    protected $guarded = ['id']; // block these field
    // Relationship one to many

    public function lessons(){
        return $this->hasMany('App\Models\Lesson');
    }
}
