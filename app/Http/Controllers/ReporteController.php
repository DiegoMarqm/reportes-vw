<?php

namespace App\Http\Controllers;
use Inertia\Inertia;

use App\Models\Empleado;


use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function index(){

        return Inertia::render('Reporte/Index');

    }

    public function create(){

        $empleados = Empleado::all();

        return Inertia::render('Reporte/Create',[
            'empleados' => $empleados
        ]);

        // return Inertia::render('Reporte/Create');
    }
}
