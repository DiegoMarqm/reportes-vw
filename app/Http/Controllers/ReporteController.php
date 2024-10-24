<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Report;
use App\Models\Empleado;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;


use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function index()
    {

        $reporte = Report::all();
        // $reporte = Report::paginate(2);

        return Inertia::render('Reporte/Index',[
            'reporte' => $reporte
        ]);
    }

    public function create()
    {

        $empleados = Empleado::all();

        return Inertia::render('Reporte/Create', [
            'empleados' => $empleados
        ]);

        // return Inertia::render('Reporte/Create');
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'numFolio' => 'required|string',
            'departamento' => 'required|string',
            'calificacion' => 'required|integer',
            'fechaQueja' => 'required|date',
            'fechaEntrega' => 'nullable|date',
            'fechaIngreso' => 'nullable|date',
            'formaDeteccion' => 'required|string',
            'redSocial' => 'nullable|string',
            'nomCliente' => 'required|string',
            'celularCliente' => 'required|string',
            'emailCliente' => 'required|string',
            'asesor' => 'required|string',
            'tipoModelo' => 'required|string',
            'placas' => 'nullable|string',
            'color' => 'required|string',
            'noOrden' => 'required|string',
            'vin' => 'required|string',
            'tecnico' => 'required|string',
            'reclamacion' => 'required|string',
            'tipoReclamacion' => 'required|string',
            'otroTipoReclamacion' => 'nullable|string',

            'causaRaiz' => 'nullable|array',

            'medidas' => 'required|array',
            'medidas.*.medida' => 'required|string',
            'medidas.*.responsable' => 'required|string',
            'medidas.*.fecha' => 'required|date',
            'procedeQueja' => 'required|boolean',
            'solucion' => 'required|string',
            'nombreCierre' => 'required|string',
            'fechaCierre' => 'required|date',
            'nombreSeguimiento' => 'required|string',
            'fechaSeguimiento' => 'required|date',
            'comentariosCliente' => 'required|string',


            //Otros campos extras

            'evidenciasReporte' => 'nullable|array',
            'reportePDF' => 'nullable|file|mimes:pdf|max:2048',


        ]);

        $validatedData['estado'] = true;
        $validatedData['evidenciasReporte'] = $validatedData['evidenciasReporte'] ?? [];


        $reporte = new Report($validatedData);

        $reporte->save();

        return redirect()->route('reporte.index');
    }

    //Agregar la funcion para ver la informacion completa del reporte:
    public function showReporte($id)
    {
        $reporte = Report::find($id);

        if ($reporte) {
            return Inertia::render('Reporte/ShowReporte', [
                'reporte' => $reporte
            ]);
        } else {
            return redirect()->route('reporte.index')->with('error', 'Reporte no encontrado');
        }
    }

    public function toogleEstado($id)
    {

        $reporte = Report::find($id);

        if ($reporte) {
            $reporte->estado = !$reporte->estado;
            $reporte->save();

            return redirect()->route('reporte.index')->with('success', 'Cambio Exitoso');
        } else {
            return redirect()->route('reporte.index')->with('error', 'Reporte no encontrado');
        }
    }
}
