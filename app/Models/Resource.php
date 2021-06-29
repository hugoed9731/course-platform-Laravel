<?php
// THIS MODEL HAS POLIMORPHYC RELATIONSHIP
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;
    protected $guarded = ['id']; // block these field
    public function resourceable(){
        return $this->morphTo();
    }
}
