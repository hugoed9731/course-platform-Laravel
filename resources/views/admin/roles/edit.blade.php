@extends('adminlte::page')

@section('title', 'Coders free')

@section('content_header')
    <h1>Editar Rol</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        {{-- Laravel collective - incluye el token cfrs y post --}}
        {!! Form::model($role, ['route' => ['admin.roles.update', $role], 'method' => 'put']) !!}
            {{-- Apuntamos a una cierta ruta --}}
            {{-- :model($role - recuperar datos de este rol --}}

            @include('admin.roles.partials.form')

            {!! Form::submit('Actualizar Role', ['class' => 'btn btn-primary mt-2']) !!}


        {!! Form::close() !!}
    </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop