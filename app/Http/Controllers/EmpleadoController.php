<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Report;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmpleadoController extends Controller
{
    public function index()
    {
        return Inertia::render('Empleados/FormularioEmpleados', [
            'empleados' => Empleado::all()->groupBy('rol')
        ]);
    }

    public function datosgrafica()
    {
        $empleadosPorRol = Empleado::select('rol', DB::raw('count(*) as total'))
            ->groupBy('rol')
            ->get();

        $reportesPorDepartamento = Report::select('departamento', DB::raw('count(*) as total'))
            ->whereIn('departamento', ['Ventas', 'Servicio', 'Refacciones', 'Seminuevos'])
            ->groupBy('departamento')
            ->get();

        $reportesTotalesPorDepartamentoTotalYear = Report::select('departamento', DB::raw('count(*) as total'))
            ->whereIn('departamento', ['Ventas', 'Servicio', 'Refacciones', 'Seminuevos'])
            ->whereYear('created_at', date('Y'))
            ->groupBy('departamento')
            ->get();

        $redesSociales = Report::select('redSocial', DB::raw('count(*) as total'))
            ->whereNotNull('redSocial')
            ->whereYear('created_at', date('Y'))
            ->where('redSocial', '!=', '')
            ->groupBy('redSocial')
            ->get();

        $reportesFinalizados = Report::select(DB::raw('count(*) as total'))
            ->where('estado', false)
            ->whereYear('created_at', date('Y'))
            ->get();


        // Guardar el numero de reportes por cada departamento por cada mes en el año actual
        $reportesPorDepartamento = Report::select('departamento', DB::raw('count(*) as total'))
            ->whereIn('departamento', ['Ventas', 'Servicio', 'Refacciones', 'Seminuevos'])
            ->whereYear('created_at', date('Y'))
            ->groupBy('departamento')
            ->get();



        // $reportesPorCadaRedSocial = Report::select('redSocial', DB::raw('count(*) as total'))
        //     ->groupBy('redSocial')
        //     ->get();

        

        $totalReportes = Report::count();



        return Inertia::render('Dashboard', [
            'empleadosPorRol' => $empleadosPorRol,
            'reportesTotal' => $totalReportes,
            'redesSociales' => $redesSociales,
            // 'reporteDepartamento' => $reportesPorDepartamento,
            'reporteDepartamento' => $reportesTotalesPorDepartamentoTotalYear,
            'reportesFinalizados' => $reportesFinalizados,

        ]);
    }

    public function create()
    {
        return Inertia::render('Empleados/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'rol' => 'required|string|max:255',
        ]);

        //
        Empleado::create($request->all());

        //Refresh a la pagina formularioEmpleado.vue

        return redirect()->back();
    }

    public function destroy($id)
    {
        Empleado::find($id)->delete();

        return redirect()->back();
    }
}
