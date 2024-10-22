<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
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

    public function getEmpleadosPorRol()
    {
        $empleadosPorRol = Empleado::select('rol', DB::raw('count(*) as total'))
            ->groupBy('rol')
            ->get();

        return Inertia::render('Dashboard', [
            'empleadosPorRol' => $empleadosPorRol
        ]);
    }

    public function create(){
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
