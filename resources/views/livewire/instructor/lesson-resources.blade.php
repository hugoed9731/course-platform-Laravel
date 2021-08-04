<div class="card" x-data="{open: false}">
    <div class="card-body bg-gray-100">

        <header>
            <h1 x-on:click="open = !open" class="cursor-pointer">
                Recursos de la lección
            </h1>
        </header>


        <div x-show="open">
            <hr class="my-2">

            @if ($lesson->resource) 
            {{-- si esta leccion tiene asociado algun recurso --}}
              <div class="flex justify-between items-center">
                    <p><i wire:click="download" class="fas fa-download text-gray-500 mr-2 cursor-pointer"></i> {{$lesson->resource->url}}</p>
                    <i wire:click="destroy" class="fas fa-trash text-red-500 cursor-pointer"></i>
              </div>
            @else
                
            <form wire:submit.prevent="save">
                <div class="flex items-center">
                    <input wire:model="file" type="file" class="form-input ml-2 flex-1">
                    <button type="submit" class="btn btn-primary text-sm">
                        Guardar
                    </button>   
                </div>

                {{-- cargando archivo --}}
                <div class="text-blue-500 font-bold mt-1" wire:loading wire:target="file">
                    {{-- solo se va a mostrar cargando ... si algo se esta cargando en file --}}
                    Cargando ...
                </div>

                {{-- mostramos si existe algun error de validacion --}}
                @error('file')
                    <span class="text-xs text-red-500">{{$message}}</span>
                @enderror

                
            </form>

            @endif
         
        </div>

    </div>
</div>

