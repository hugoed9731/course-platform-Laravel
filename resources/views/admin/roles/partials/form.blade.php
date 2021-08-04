  {{-- form-control es una clase de bootstrap --}}
  <div class="form-group">
    {!! Form::label('name', 'Nombre: ') !!}
    {!! Form::text('name', null, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => 'Escriba un nombre']) !!}
    {{-- ($errors->has('name') - si tiene informacion del campo name, la informacio ha fallado --}}
    {{-- si la validacion no ha fallado concatenalo con una cadena vacia else = : --}}
    
    {{-- solo si ha ocurrido un error en el campo name se ejecuta esto --}}
    @error('name')
        <span class="invalid-feedback">
            <strong>{{$message}}</strong>
        </span>
        {{-- invalid-feedback - necesita un input is-invalid justo arriba, si no no funciona --}}
    @enderror
</div>


<strong>Permisos</strong>

@error('permissions')
<br>
<small class="text-danger">
    <strong>{{$message}}</strong>
</small>
<br>
@enderror

@foreach ($permissions as $permission)
    <div>
        <label>
            {!! Form::checkbox('permissions[]', $permission->id, null, ['class' => 'mr-1']) !!}
            {{$permission->name}}
        </label>
    </div>
@endforeach