<?php

namespace App\Observers;
use App\Models\Section;
use Illuminate\Support\Facades\Storage;

class SectionObserver
{
    public function deleting (Section $section) {
        // este metodo se va activar cuando queramos eliminar una seccion
        foreach ($section->lessons as $lesson) {
            if ($lesson->resource) {
                Storage::delete($lesson->resource->url);
                // elimina el archivo de la carpeta resource
                
                // elimina el registro de la bd
                $lesson->resource->delete();
            }
        }
    }
}
