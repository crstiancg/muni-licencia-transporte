<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUsuariosRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index(Request $request)
    {
        return $this->generateViewSetList(
            $request,
            User::query(),
            [],
            ['name'],
            ['id']
        );
    }

    public function store(StoreUsuariosRequest $request)
    {
        $user = User::create($request->all());

        return $user;
    }

    public function show(User $usuario)
    {
        return $usuario;
    }

    public function update(StoreUsuariosRequest $request, User $usuario)
    {
        $usuario->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->filled('password') ? bcrypt($request->password) : $usuario->password,
        ]);

        return $usuario;
    }

    public function destroy(User $user)
    {
        //
    }

    public function cambiarEstado(User $usuario)
    {
        if($usuario->estado === 1){
            $usuario->estado = 0;
            $usuario->save(); 
        } else {
            $usuario->estado = 1;
            $usuario->save(); 
        }

        return $usuario;
    }
}
