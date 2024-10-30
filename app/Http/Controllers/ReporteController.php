<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Report;
use App\Models\Empleado;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;


use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function index()
    {

        $reporte = Report::all();
        // $reporte = Report::paginate(2);

        return Inertia::render('Reporte/Index', [
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

    public function editReporte($id)
    {
        $reporte = Report::find($id);
        $empleados = Empleado::all();

        if ($reporte) {
            return Inertia::render('Reporte/Edit', [
                'reporte' => $reporte,
                'empleados' => $empleados
            ]);
        } else {
            return redirect()->route('reporte.index')->with('error', 'Reporte no encontrado');
        }
    }

    public function update(Request $request, $id)
    {
        $reporte = Report::find($id);

        if ($reporte) {
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

            ]);

            $reporte->update($validatedData);

            return redirect()->route('reporte.index')->with('success', 'Reporte actualizado correctamente');
        } else {
            return redirect()->route('reporte.index')->with('error', 'Reporte no encontrado');
        }
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

    public function generarPDF($id)
    {
        // Buscar el reporte por su ID
        $reporte = Report::findOrFail($id);
        // Cargar una vista con los datos del reporte
        $pdf = Pdf::loadView('reportes.pdf', ['reporte' => $reporte])
            ->setPaper('legal');
        // Descargar el PDF con el nombre del archivo

        // return $pdf->download('reporte_' . $reporte->numFolio . '.pdf');
        return $pdf->stream('reporte_' . $reporte->numFolio . '.pdf');
    }


    // Subir o reemplazar el archivo PDF
    public function subirPDF(Request $request, $id)
    {
        $reporte = Report::findOrFail($id);

        // Validar que se suba un archivo PDF
        $request->validate([
            'reportePDF' => 'required|mimes:pdf|max:5120',

        ]);

        // Eliminar el archivo anterior si existe
        if ($reporte->reportePDF) {
            Storage::delete('public/escaneos/' . $reporte->reportePDF);
        }
        // Obtener el número de folio del reporte
        $numFolio = $reporte->numFolio;
        // Definir el nombre del archivo PDF, usando el folio
        $fileName = 'reporte_' . $numFolio . '.' . $request->file('reportePDF')->getClientOriginalExtension();
        // Subir el archivo a la carpeta "escaneos"
        $path = $request->file('reportePDF')->storeAs('escaneos', $fileName, 'public');

        // Actualizar el campo en la base de datos
        $reporte->update([
            'reportePDF' => $path,
        ]);

        return back()->with('success', 'El archivo PDF se ha subido correctamente.');
    }


    // Eliminar el archivo PDF
    public function eliminarPDF($id)
    {
        $reporte = Report::findOrFail($id);

        if ($reporte->reportePDF) {
            // Eliminar el archivo del sistema
            // Storage::delete($reporte->reportePDF); // Elimina el archivo usando la ruta parcial

            $storagePath = $reporte->reportePDF;

            // Eliminar la carpeta del almacenamiento
            if (Storage::disk('public')->exists($storagePath)) {
                Storage::disk('public')->delete($storagePath);
                //eliminar solo el archivo
                //Storage::disk('public')->delete($storagePath);
                // Actualizar el campo en la base de datos
                $reporte->update([
                    'reportePDF' => null,
                ]);
            }
            return back()->with('success', 'El archivo PDF se ha eliminado correctamente.');
        }
        return back()->with('error', 'No se encontró ningún archivo para eliminar.');
    }
}
