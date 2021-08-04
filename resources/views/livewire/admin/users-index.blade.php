<div>
    <div class="card">

        <div class="card-header">
            <input wire:keydown="limpiar_page" wire:model="search" class="form-control w-100" placeholder="Escriba un nombre ...">
            {{-- sincronizamo $search con lo que escribamos aquí --}}
            {{-- limpiarPage se va a ejecutar cuando se empiece a escribir --}}
        </div>

        @if ($users->count())
        {{-- count - devuelve cantidad de registros que hay en esta coleccion --}}

        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($users as $user) 
                        {{-- // cada nuevo registro que encuentres almacenalo en la variable temporal --}}
                        <tr>
                            <td>{{$user->id}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td width="10px">
                                {{-- width="10px" - acomoda el boton a la derecha --}}
                                <a class="btn btn-primary" href="{{route('admin.users.edit', $user)}}">Editar</a>
                                {{-- registro de usuario el parametro que nos pide --}}
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            {{$users->links()}}
        </div>
        @else

            <div class="card-body">
                <strong>No hay registros...</strong>
            </div>

        @endif

       
    </div>
</div>
