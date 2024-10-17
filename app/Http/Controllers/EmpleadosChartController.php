<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;

class EmpleadosChartController extends Controller
{
    public function index()
    {
        $empleadosPorRol = Empleado::selectRaw("COUNT(*) as count")
            ->whereYear('created_at', date('Y'))
            ->groupBy('rol')
            ->pluck('count');

        return response()->json($empleadosPorRol);
    }
}
