<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;

class UserController extends Controller
{
   
    public function __construct()
    {
        // proteccion de rutas segun roles
        $this->middleware('can:Leer usuarios')->only('index'); 
        $this->middleware('can:Editar usuarios')->only('edit', 'update'); 

    }


    public function index()
    {
        return view('admin.users.index');
    }

   
    public function edit(User $user)
    {
        // recuperamos todo el registro de roles
        $roles = Role::all();

        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
      //  return $request->all(); retorname lo que se esta mandando

    //   accedemos al registro del usuario -
    // accedemos a la relacion roles, pedimos que nos sincronice syn con los roles que a¿mandamos por form
        $user->roles()->sync($request->roles);

        return redirect()->route('admin.users.edit', $user);
    }

}
