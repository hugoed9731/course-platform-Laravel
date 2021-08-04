<section>
    <h1 class="text-2xl font-bold">REQUERIMIENTOS DEL CURSO</h1>
    <hr class="mt-2 mb-6">


    @foreach ($course->requirements as $item)
        {{-- accede a la propiedad course y a la relacion goals --}}
        <article class="card mb-4">
            <div class="card-body bg-gray-100">
              

                    @if ($requirement->id == $item->id)
                            {{-- si estos valores coinciden muestrame un formulario  --}}
                            <form wire:submit.prevent="update">
                                <input wire:model="requirement.name" class="form-input w-full h-10 border rounded  focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-transparent ...">


                                @error('requirement.name')
                                    <span class="text-xs text-red-500">{{$message}}</span>
                                @enderror
                            </form>
                    @else
                    <header class="flex justify-between">
                        <h1>{{$item->name}}</h1>
                        <div>
                            {{-- $item - registro de la meta que queremos editar --}}
                            <i wire:click="edit({{$item}})" class="fas fa-edit text-blue-500 cursor-pointer"></i>
                            <i wire:click="destroy({{$item}})" class="fas fa-trash text-red-500 cursor-pointer ml-2"></i>
                        </div> 
                     </header>

                    @endif

            </div>
        </article>
    @endforeach


    <article class="card">
        <div class="card-body bg-gray-100">
            <form wire:submit.prevent="store">
                <input wire:model="name" class="form-input w-full h-10 border rounded  focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-transparent ..." placeholder="Agregar el nombre de un requerimento">

                @error('name')
                    <span class="text-xs text-red-500">{{$message}}</span>
                @enderror

                <div class="flex justify-end mt-2">
                    <button type="submit" class="btn btn-primary">
                        Agregar requerimiento
                    </button>
                </div>
            </form>
        </div>
    </article>
</section>
