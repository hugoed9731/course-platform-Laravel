<x-app-layout>

    <section class="bg-gray-700 py-12 mb-12">
        <div class="container grid grid-cols-1 lg:grid-cols-2 gap-6">
            <figure>
                <img class="h-60 w-full object-cover" src="{{Storage::url($course->image->url)}}" alt="">
            </figure>

            <div class="text-white">
                <h1 class="text4-xl">{{$course->title}}</h1>
                <h2 class="text-xl mb-3">{{$course->subtitle}}</h2>
                <p class="mb-2"> <i class="fas fa-chart-line"></i> Nivel: {{$course->level->name}}</p>
                <p class="mb-2"> <i class=""></i> Categoría: {{$course->category->name}}</p>
                <p class="mb-2"> <i class="fas fa-users"></i> Matriculados:  {{$course->students_count}}</p>
                <p> <i class="far fa-star"></i> Calificación:  {{$course->rating}}</p>
            </div>
        </div>
    </section>


    <div class="container grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="order-2 lg:col-span-2 lg:order-1">
            <section class="card mb-12">
                <div class="card-body">
                    <h1 class="font-bold text-2xl mb-2">Lo que aprenderás</h1>

                    <ul class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-2">
                        @foreach ($course->goals as $goal)
                            {{-- course le pedimos que rescate la relacion con las metas --}}
                            <li class="text-gray-700 text-base"> <i class="fas fa-check text-gray-600 mr-2"></i> {{$goal->name}}</li>
                        @endforeach
                    </ul>
                </div>
            </section>


            {{-- TEMARIO --}}

            <section class="mb-12">
                <h1 class="font-fold text-3xl mb-2">Temario</h1>

                @foreach ($course->sections as $section)
                    <article class="mb-4 shadow" 
                    @if ($loop->first)
                        {{-- estamos dentro de un bucle que es el forech --}}
                        {{-- si estamos en la primera interasion va a dar verdadero, entonces vamos a definir --}}
                        x-data="{open: true}"
                    @else
                    x-data="{open: false}"
                    @endif>
                        {{-- x-data definimos una variable en alpine --}}
                        <header class="border border-gray-200 px-4 py-2 cursor-pointer bg-gray-200" x-on:click="open = !open">
                            {{-- x-on:click="open = !open" - esto es un evento con alpine --}}
                            <h1 class="font-bold text-lg text-gray-600">{{$section->name}}</h1>
                        </header>


                        <div class="bg-white py-2 px-4" x-show="open">
                            <ul class="grid grid-cols-1 gap-2">
                                @foreach ($section->lessons as $lesson)
                                    {{-- recupera todas las lecciones que corresponden a una determinada seccion --}}
                                    <li class="text-gray-700 text-base"> <i class="fas fa-play-circle mr-2 text-gray-600"></i> {{$lesson->name}}</li>
                                @endforeach
                            </ul>
                        </div>
                    </article>
                @endforeach
            </section>


            {{-- Requisitos --}}

            <section class="mb-8">
                <h1 class="font-bold text-3xl text-gray-800">Requisitos</h1>

                <ul class="list-disc list-inside">
                    @foreach ($course->requirements as $requirement)
                        <li class="text-gray-700 text-base">{{$requirement->name}}</li>
                    @endforeach
                </ul>
            </section>


            <section>
                <h1 class="font-bold text-3xl text-gray-800">Descripción</h1>

                <div class="text-gray-700 text-base">
                    {!!$course->description!!}
                </div>
            </section>


            @livewire('courses-reviews', ['course' => $course])



        </div>

        <div class="order-1 lg:order-2">
            <section class="card mb-4">
                <div class="card-body">

                    <div class="flex items-center">
                        <img class="h-12 w-12 object-cover rounded-full shadow-lg" src="{{$course->teacher->profile_photo_url}}" alt="{{$course->teacher->name}}">
                    
                        <div class="ml-4">
                            <h1 class="font-bold text-gray-500 text-lg">Prof. {{$course->teacher->name}}</h1>
                            <a class="text-blue-400 text-sm font-bold">{{ '@' . Str::slug($course->teacher->name, '') }}</a>
                            {{-- a - aqui vamos a imprimir el slut del nombre del profesor, '' - quita los espaciados --}}

                        </div>
                    </div>

                    {{-- can - validar que el usuario posea el permiso especificado --}}
                    @can('enrolled', $course)

                        <a class="btn btn-danger btn-block mt-4" href="{{route('courses.status', $course)}}">Continuar con el curso</a>
                    
                    @else
                        {{-- cuando no este matriculado muestra este botón --}}
                        {{-- formulario para matricularte a un curso --}}
                        @if ($course->price->value == 0)
                            <p class="text-2xl font-bold text-gray-500 mt-3 mb-2">GRATIS</p>

                            <form action="{{route('courses.enrolled', $course)}}" method="post">
                            {{-- cuando mandamos cosas por formulario se incluye el token csrf --}}
                            @csrf
                            <button  class="btn btn-danger btn-block" type="submit">Llevar este curso</button>
                            </form>
                        @else 
                        <p class="text-2xl font-bold text-gray-500 mt-3 mb-2">US$ {{$course->price->value}}</p>
                        <a href="{{route('payment.checkout', $course)}}" class="btn btn-danger btn-block ">Comprar este curso</a>
                        {{-- si el curso tiene costo muestra esto --}}
                         @endif
                    @endcan



                   

                </div>
            </section>


            <aside class="hidden lg:block">
                {{-- iteramos todos los cursos similares --}}
                @foreach ($similares as $similar)
                    <article class="flex mb-6">
                        {{-- retorna la relacion image, y una vez teniendola accede a la url --}}
                        <img class="h-32 w-40 object-cover" src="{{Storage::url($similar->image->url)}}" alt="">
                        <div class="ml-3">
                            {{-- {{route('courses.show', $similar)}} - te redirecciona al curso sugerido --}}
                            <h1><a class="font-bold text-gray-500 mb-3" href="{{route('courses.show', $similar)}}">
                                {{Str::limit($similar->title, 40)}}</a>
                            </h1>
                            {{-- Str::limit($similar->title, 40 - le especificamos la cantidad de texto que queremos mostrar --}}
                        {{-- foto del profesor --}}
                            <div class="flex items-center mb-2">
                                <img class="h-8 w-8 object-cover rounded-full shadow-lg" src="{{$similar->teacher->profile_photo_url}}" alt="">
                                <p class="text-gray-700 text-sm ml-2">{{$similar->teacher->name}}</p>
                            </div>

                            {{-- calificacion --}}

                            <p class="text-sm">
                                <i class="fas fa-star mr-2 text-yellow-400"></i>
                                {{$similar->rating}}
                            </p>

                        </div>
                    </article>
                @endforeach
            </aside>
        </div>
    </div>

</x-app-layout>