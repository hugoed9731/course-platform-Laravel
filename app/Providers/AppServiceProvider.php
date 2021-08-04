<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
// observer
use App\Models\Lesson;
use App\Models\Section;
use App\Observers\LessonObserver;
use App\Observers\SectionObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        // HACEMOS UNOS DEL LESSONOBSERVER
        Lesson::observe(LessonObserver::class);
        Section::observe(SectionObserver::class);


        // en este metodo podemos generar nuestras directivas de blade
        Blade::directive('routeIs', function ($expression) {
            return "<?php if(Request::url() == route($expression)): ?>";

            // if(Request::url()) - nos devuelve la url en la que nos encontramos actualmente
            // preguntamos si esta url coincide con la url actual
        });
    }
}
