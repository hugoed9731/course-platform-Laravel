<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    use HasFactory;
    protected $guarded = ['id']; // block these field
      // Relationships one to many inverse
      public function course(){
        return $this->belongsTo('App\Models\Course');
    }
}
