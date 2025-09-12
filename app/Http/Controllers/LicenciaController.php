<?php

namespace App\Http\Controllers;

use App\Models\Licencia;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LicenciaController extends Controller
{

    public function index(Request $request)
    {
        // $licencias = Licencia::limit(10)->orderby('id', 'desc')->get();

        // return Inertia::render('Dashboard', [
        //     'licencias' => $licencias
        // ]);

        return $this->generateViewSetList(
            $request,
            Licencia::query(),
            [],
            ['nombre_conductor', 'placa'],
            ['id', 'nombre_conductor']
        );

        //  return Inertia::render('Dashboard', [
        //     'licencias' => $licencias
        // ]); 
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $licencia = Licencia::create($request->all());

        return $licencia;
    }

    public function show(Licencia $licencia)
    {
        return $licencia;
    }

    public function edit(Licencia $licencia)
    {
        //
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
