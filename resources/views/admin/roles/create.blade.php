@extends('adminlte::page')

@section('title', 'Coders free')

@section('content_header')
    <h1>Crear nuevo rol</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        {{-- Laravel collective - incluye el token cfrs y post --}}
        {!! Form::open(['route' => 'admin.roles.store']) !!}
            {{-- Apuntamos a una cierta ruta --}}

            @include('admin.roles.partials.form')

            {!! Form::submit('Crear Role', ['class' => 'btn btn-primary mt-2']) !!}


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

{{-- Aquí se va a utilizar la libreria laravel collective para los formularios --}}