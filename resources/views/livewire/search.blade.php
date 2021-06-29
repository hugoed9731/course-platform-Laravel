    <form class="pt-2 relative mx-auto text-gray-600" autocomplete="off">
        {{-- autocomplete="off" - quitamos el autocomplete que viene por defecto --}}
        <input  wire:model="search"
            class="w-full border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg text-sm focus:outline-none"
            type="search" name="search" placeholder="Search">

        <button type="submit"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded absolute right-0 top-0 mt-2">
            Buscar
        </button>

       
        @if ($search)
             {{-- si hay algo en la propiedad search - muestro el contenido --}}
        {{-- solo queremos que se filtre esto si el usuario ha escrito algo en el input --}}
        <ul class="absolute z-50 left-0 w-full bg-white mt-1 rounded-lg overflow-hidden">
            {{-- filtramos todos los cursos --}}
            @forelse ($this->results as $result)
            <li class="leading-10  px-5 text-sm cursor-pointer hover:bg-gray-300">
                {{-- redirecciona algun curso buscado al curso en si --}}
               <a href="{{route('courses.show', $result)}}">{{$result->title}}</a> 
            </li>
            {{-- mostrar cuando no haya ningun registro  --}}
            @empty
            <li class="leading-10  px-5 text-sm cursor-pointer hover:bg-gray-300">
                No hay ninguna coincidencia :(
            </li>
            {{-- forelse te permite mostrar algo en el caso de que no haya ninguna informacion
                 - esas es la diferencia con foreach --}}
            @endforelse
        </ul>
        @endif
    </form>