<x-app-layout>
    <div class="container py-8">
        <div class="card">
            <div class="card-body">
                <h1 class="text-2xl font-bold">CREAR NUEVO CURSO</h1>

                <hr class="mt-2 mb-6">

                {!! Form::open(['route' => 'instructor.courses.store', 'files' => true, 'autocomplete' => 'off']) !!}
                {{-- le vamos a pasar un input oculto de user id, ya que pide todos los campos para crear usuario --}}

                {!! Form::hidden('user_id', auth()->user()->id) !!}

                {{-- habilitamos el envio de imagenes --}}
                    @include('instructor.courses.partials.form') 
                    
                    
                    <div class="flex justify-end">
                        {!! Form::submit('Crear nuevo curso', ['class' => 'btn btn-primary cursor-pointer']) !!}
                    </div>
                {!! Form::close() !!}

            </div>
        </div>
    </div>


    <x-slot name="js">
        <script src="https://cdn.ckeditor.com/ckeditor5/29.0.0/classic/ckeditor.js"></script>
       
        {{-- esto es un slot con nombre porque le asignamos un nombre --}}
        <script src="{{asset('js/instructor/courses/form.js')}}"></script>

    </x-slot>

</x-app-layout>