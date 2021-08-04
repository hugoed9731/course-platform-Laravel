<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{

    public function __construct()
    {
        // middleware para las rutas
        $this->middleware('can:Listar role')->only('index'); //especificamos que solo queremos que protega al metodos index
        $this->middleware('can:Crear role')->only('create', 'store'); 
        $this->middleware('can:Editar role')->only('edit', 'update'); 
        $this->middleware('can:Eliminar role')->only('edit', 'destroy'); 
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all(); // rescatamos todos los registros de roles que tenemos en la bd

        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validacion campos vacios
        $request->validate([
            'name' => 'required',
            'permissions' => 'required'
        ]);
        
        // crear rol
        $role = Role::create([
            // informacion que mandamos del formulario
            'name' => $request->name
        ]);

        // accedemos a la relacion permissions
        // $request->permissios - recuperamos el id de los checkbucks - esto queda registradi en la tabla intermedia
        $role->permissions()->attach($request->permissions);
        
        return redirect()->route('admin.roles.index')->with('info', 'El rol se creo satisfactoriamente');
        // with - ventana de aviso
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return view('admin.roles.show', compact('role'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all();

        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
         // validacion campos vacios
         $request->validate([
            'name' => 'required',
            'permissions' => 'required'
        ]);

        $role->update([
            'name' =>$request->name
            // actualiza el nombre de este rol por el que estamos mandando desde el formulario
        ]);
        
        // actualizar permisos de un determinado rol
        $role->permissions()->sync($request->permissions);
        // sync elimina todos los permisos de un determinado rol, luego los genera nuevamente con los new

        return redirect()->route('admin.roles.edit', $role);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->route('admin.roles.index')->with('info', 'El rol se elimino con éxito');

    }
}
