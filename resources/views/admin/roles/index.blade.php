@extends('adminlte::page')

@section('title', 'Coders free')

@section('content_header')
    <h1>Lista de roles</h1>
@stop

@section('content')

@if (session('info'))

<div class="alert alert-primary" role="alert">
    <strong>¡Éxito!</strong>
    {{session('info')}}
</div>

@endif


<div class="card">

    <div class="card-header">
        <a href="{{route('admin.roles.create')}}">Crear Role</a>
    </div>

    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th colspan="2"></th>
                </tr>
            </thead>

           <tbody>
                {{-- forelse - te permite imprimir algo en caso de que la colecion este vacia --}}
                @forelse ($roles as $role)
                    <tr>
                        <td>{{$role->id}}</td>
                        <td>{{$role->name}}</td>
                        <td width="10px">
                            <a class="btn btn-secondary" href="{{route('admin.roles.edit', $role)}}">Editar</a>
                            {{-- el segundo parametro - el registro que queremos editar --}}
                        </td>


                        <td width="10px">
                            {{-- este form va mediante destroy --}}
                            <form action="{{route('admin.roles.destroy', $role)}}" method="POST">
                                @method('delete')
                                @csrf
                                {{-- proteccion del token - brindamos mas protecion al formulario --}}

                                <button class="btn btn-danger" type="submit">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                {{-- en el caso de que la coleccion este vacia, hacemos lo siguiente --}}
                    <tr>
                        <td colspan="4">No hay ningún rol registrado</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop