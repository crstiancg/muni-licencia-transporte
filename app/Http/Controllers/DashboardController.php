<?php

namespace App\Http\Controllers;

use App\Models\Licencia;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [];

        $data['total_registrados_hoy'] = Licencia::whereDate('created_at', now())->count();
        $data['total'] = Licencia::count();
        $data['total_vehiculos_autorizados'] = Licencia::where('estado', 'autorizado')->count();

        $data['total_vehiculos_no_autorizados'] = Licencia::where('estado','no_autorizado')->count();

        $data['total_vehiculos_recientes'] = Licencia::latest()->take(7)->get()->map(function ($licencia) {
            $licencia->fecha_humana = $licencia->created_at->diffForHumans();
            return $licencia;
        });

        $data['empresa'] = Licencia::select('empresa', DB::raw('COUNT(*) as total'))
            ->where('estado', 'autorizado')
            ->groupBy('empresa')
            ->orderByDesc('total')
            ->take(5)
            ->get();
        $data['empresa_no'] = Licencia::select('empresa', DB::raw('COUNT(*) as total'))
            ->where('estado', 'no_autorizado')
            ->groupBy('empresa')
            ->orderByDesc('total')
            ->take(5)
            ->get();


        return Inertia::render('Dashboard', compact('data'));
    }
}
