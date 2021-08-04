<x-instructor-layout :course='$course'>
{{-- : indica que es un variable de php --}}

    
    

    <h1 class="text-2xl font-bold">INFORMACIÓN DEL CURSO</h1>
    <hr class="mt-2 mb-6">

    {{-- lo abrimos con model, para recuperar toda la informacion de ese curso --}}
    {!! Form::model($course, ['route' => ['instructor.courses.update', $course], 'method' => 'put', 'files' => true])
    !!}
    {{-- habilitamos el envio de archivos - 'files' => true --}}

    @include('instructor.courses.partials.form')

    <div class="flex justify-end">
        {!! Form::submit('Actualizar información', ['class' => 'btn btn-primary']) !!}
    </div>

    {!! Form::close() !!}

    <x-slot name="js">
        <script src="https://cdn.ckeditor.com/ckeditor5/29.0.0/classic/ckeditor.js"></script>

        {{-- esto es un slot con nombre porque le asignamos un nombre --}}
        <script src="{{asset('js/instructor/courses/form.js')}}"></script>

    </x-slot>

</x-instructor-layout>
