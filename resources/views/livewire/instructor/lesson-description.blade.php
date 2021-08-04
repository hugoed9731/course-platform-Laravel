<div>

    <article class="card" x-data="{open: false}">
        <div class="card-body bg-gray-100">
            <header>
                <h1 x-on:click="open = !open" class="cursor-pointer">Descripción de la lección</h1>
            </header>
        

        <div x-show="open">
            <hr class="my-2">

            @if ($lesson->description)
                {{-- si esta leccion tiene una descripcion abrimos un form --}}
                <form wire:submit.prevent="update">
                    <textarea wire:model="description.name" class="form-input w-full h-20 border rounded  focus:outline-none focus:ring-2 focus:ring-blue-300 "></textarea>

                    @error('description.name')
                        <span class="text-sm text-red-500">{{$message}}</span>
                    @enderror

                    <div class="flex justify-end">
                        <button wire:click="destroy" class="btn btn-danger text-sm" type="button">Eliminar</button>
                        
                        <button class="btn btn-primary text-sm ml-2" type="submit">Actualizar</button>
                    </div>
                </form>

                @else 
                {{-- si esta leccion tiene una descripcion abrimos un form --}}
                {{-- cambiamos form a div, porque livewire a la hora de renderizar pensara que son los mismos --}}
                <div>
                    <textarea wire:model="name" placeholder="Agregue una descripción de la lección" class="form-input w-full h-20 border rounded  focus:outline-none focus:ring-2 focus:ring-blue-300 "></textarea>

                    @error('name')
                        <span class="text-sm text-red-500">{{$message}}</span>
                    @enderror

                    <div class="flex justify-end">
                        
                        <button wire:click="store" class="btn btn-primary text-sm ml-2">Agregar</button>
                    </div>
                </div>
            @endif
             </div>
        </div>
    </article>

</div>
