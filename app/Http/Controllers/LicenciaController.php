<?php

namespace App\Http\Controllers;

use App\Models\Licencia;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LicenciaController extends Controller
{

    public function index(Request $request)
    {
        return Inertia::render('Licencias/LicenciasList');
; 
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        
    }

    public function show(Licencia $licencia)
    {
        
    }

    public function edit(Licencia $licencia)
    {
        //
    }

    public function update(Request $request, Licencia $licencia)
    {
        
    }

    public function destroy(Licencia $licencia)
    {
        //
    }
}
