<?php
// THIS MODEL HAS POLIMORPHYC RELATIONSHIP
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $guarded = ['id']; // block these field
    public function imageable(){
        return $this->morphTo();
    }
}
