<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLicenciaRequest;
use App\Models\Licencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class LicenciaController extends Controller
{
    
    public function index(Request $request)
    {
         return $this->generateViewSetList(
            $request,
            Licencia::query(),
            [],
            ['nombre_conductor', 'placa'],
            ['id', 'nombre_conductor']
        );
    }

    public function store(StoreLicenciaRequest $request)
    {
        DB::beginTransaction();
    
        try {

            if (!Auth::check()) {
                return response()->json(['error' => 'Usuario no autenticado'], 401);
            }
            $placa = data_get($request,'placa');
            
            Licencia::where('placa', $placa)
                ->where('estado', 'autorizado') // Solo actualizamos los registros con estado 'autorizado'
                ->update(['estado' => 'no_autorizado']);
            
            $data = $request->all();

            // $user = Auth::user();
            // $userId = $user->id;

            $data['user_id'] = Auth::id();

            $licencia = Licencia::create($data);
    
            // Si todo fue exitoso, hacemos commit de la transacción
            DB::commit();
    
            // Redirigir a la lista de circulaciones
            // return Redirect::route('circulacion.index');
        } catch (\Exception $e) {
            // Si algo salió mal, hacemos rollback de la transacción
            DB::rollback();
    
            // En este caso, puedes redirigir a alguna página con un mensaje de error
            return back()->withErrors(['error' => 'Hubo un problema al crear el registro. Intente nuevamente.']);
        }
    }

    public function show(Licencia $licencia)
    {
        return $licencia;
    }

    public function update(Request $request, Licencia $licencia)
    {
        $licencia->update($request->all());

        return $licencia;
    }

    public function destroy(Licencia $licencia)
    {
        //
    }
}
