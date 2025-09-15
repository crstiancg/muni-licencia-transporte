<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLicenciaRequest;
use App\Models\Licencia;
use Illuminate\Http\Request;

class LicenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLicenciaRequest $request)
    {
        $licencia = Licencia::create($request->all());

        return $licencia;
    }

    /**
     * Display the specified resource.
     */
    public function show(Licencia $licencia)
    {
        return $licencia;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Licencia $licencia)
    {
        $licencia->update($request->all());

        return $licencia;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Licencia $licencia)
    {
        //
    }
}
