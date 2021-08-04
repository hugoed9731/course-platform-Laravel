{{-- pasar variable como un atributo del componente --}}
@props(['course'])


<article class="card flex flex-col">
    {{-- acceder a la relacion que hay entre cursos e imagenes --}}
    <img class="h-36 w-full object-cover" src="{{Storage::url($course->image->url)}}" alt="">

    <div class="card-body flex-1 flex flex-col">
        <h1 class="card-title">{{Str::limit($course->title, 40)}}</h1>
        {{-- leading - separacion vertical entre el texto 
                Str- es un ayudante para poner eventos en este caso limit 
                --}}
        {{-- Accedemos a la relacion de maestro y cursos --}}
        <p class="text-gray-500 text-sm mb-2 mt-auto">Prof: {{$course->teacher->name}}</p>
        {{-- Rating estrellas --}}
        <div class="flex">

            <ul class="flex text-sm">
                {{-- condicional con operadores ternarios ? - if : es igual a else --}}
                <li class="mr-1"><i
                        class="fas fa-star text-{{$course->rating >=1 ? 'yellow' : 'gray'}}-400"></i></li>
                <li class="mr-1"><i
                        class="fas fa-star text-{{$course->rating >=2 ? 'yellow' : 'gray'}}-400"></i></li>
                <li class="mr-1"><i
                        class="fas fa-star text-{{$course->rating >=3 ? 'yellow' : 'gray'}}-400"></i></li>
                <li class="mr-1"><i
                        class="fas fa-star text-{{$course->rating >=4 ? 'yellow' : 'gray'}}-400"></i></li>
                <li class="mr-1"><i
                        class="fas fa-star text-{{$course->rating ==5 ? 'yellow' : 'gray'}}-400"></i></li>
            </ul>

            {{-- cantidad de usuarios matriculados --}}

            <p class="text-sm text-gray-500 ml-auto">
                <i class="fas fa-users"></i>
                {{$course->students_count}}
            </p>
        </div>


        {{-- Precios $--}}

        @if ($course->price->value == 0)
        <p class="my-2 text-green-800 font-bold">GRATIS</p>
        @else
        <p class="my-2 text-gray-500 font-bold">US$ {{$course->price->value}}</p>
        @endif

        <a href="{{route('courses.show', $course)}}"
            class="btn-block btn btn-primary">
            Más infomación
        </a>

    </div>
</article>