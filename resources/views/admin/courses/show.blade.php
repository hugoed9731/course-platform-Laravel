<x-app-layout>

    <section class="bg-gray-700 py-12 mb-12">
        <div class="container grid grid-cols-1 lg:grid-cols-2 gap-6">
            <figure>
                @if ($course->image)
                {{-- si existe un curso asocioado al curso imprime la imagen --}}
                <img class="h-60 w-full object-cover" src="{{Storage::url($course->image->url)}}" alt="">
                @else
                {{-- si no existe ninguna imagen, imprime una estandar --}}
                <img class="h-60 w-full object-cover" src="https://images.pexels.com/photos/5940721/pexels-photo-5940721.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940" alt="">
                @endif
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

        @if (session('info'))
        {{-- si existe una variable de sesion en una variable llamada info --}}
            <div class="lg:col-span-3" x-data="{open: true}" x-show="open">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    <strong class="font-bold"></strong>
                    <span class="block sm:inline">{{session('info')}}</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                        <svg x-on:click="open=false" class="w-4 h-4 fill-current" role="button" viewBox="0 0 20 20"  ><path d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" fill-rule="evenodd"></path></svg>
                    </span>
                </div>
            </div>

        
        @endif

        <div class="order-2 lg:col-span-2 lg:order-1">

            {{-- Metas --}}

            <section class="card mb-12">
                <div class="card-body">
                    <h1 class="font-bold text-2xl mb-2">Lo que aprenderás</h1>

                    <ul class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-2">

                        @forelse ($course->goals as $goal)
                        {{-- si tiene metas imprimi aqui --}}
                        <li class="text-gray-700 text-base"> <i class="fas fa-check text-gray-600 mr-2"></i> {{$goal->name}}</li>
                        @empty
                        {{-- si no tiene metas, imprime un mensaje --}}
                        <li class="text-gray-700 text-base">Este curso no tiene asignada ninguna meta</li>
                        @endforelse

                    </ul>
                </div>
            </section>


            {{-- TEMARIO --}}

            <section class="mb-12">
                <h1 class="font-fold text-3xl mb-2">Temario</h1>

                @forelse ($course->sections as $section)
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
                    {{-- en el caso de que no tenga ninguna leccion, imprime lo siguiente --}}
                    @empty

                        <article class="card">
                            <div class="card-body">
                                Este curso no tiene ninguna sección asignada
                            </div>
                        </article>

                @endforelse
            </section>


            {{-- Requisitos --}}

            <section class="mb-8">
                <h1 class="font-bold text-3xl">Requisitos</h1>

                <ul class="list-disc list-inside">
                    @forelse ($course->requirements as $requirement)
                        <li class="text-gray-700 text-base">{{$requirement->name}}</li>
                        @empty
                        <li class="text-gray-700 text-base">Este curso no tiene ningún requerimiento</li>
                    @endforelse
                </ul>
            </section>


            <section>
                <h1 class="font-bold text-3xl">Descripcion</h1>

                <div class="text-gray-700 text-base">
                    {!!$course->description!!}
                    {{-- !! le indicamos a bladee que queremos que introduzca código html --}}

                </div>
            </section>



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
                    <form action="{{route('admin.courses.approved', $course)}}" class="mt-4" method="POST">
                        @csrf

                        <button type="submit" class="btn btn-primary w-full">Aprobar curso</button>
                    </form>

                    <a href="{{route('admin.courses.observation', $course)}}"  class="btn btn-danger w-full block text-center mt-4">Observar curso</a>

                </div>
            </section>


        </div>
    </div>

</x-app-layout>