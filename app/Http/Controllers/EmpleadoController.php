<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Report;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


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
        $currentYear = Carbon::now()->year;

        // Total de reportes del año actual
        $totalReportes = Report::whereYear('fechaQueja', $currentYear)->count();

        // Porcentaje de quejas procedentes
        $procedentes = Report::whereYear('fechaQueja', $currentYear)->where('procedeQueja', true)->count();
        $porcentajeProcedentes = $totalReportes > 0 ? ($procedentes / $totalReportes) * 100 : 0;

        // Calificación promedio
        $calificacionPromedio = Report::whereYear('fechaQueja', $currentYear)->avg('calificacion');

        // Tiempo promedio de resolución
        $tiempoResolucion = Report::whereYear('fechaQueja', $currentYear)
            ->whereNotNull('fechaCierre')
            ->selectRaw('AVG(DATEDIFF(fechaCierre, fechaQueja)) as promedio')
            ->value('promedio');

        // Quejas por mes
        $quejasPorMes = Report::whereYear('fechaQueja', $currentYear)
            ->selectRaw('MONTH(fechaQueja) as mes, COUNT(*) as total')
            ->groupBy('mes')
            ->orderBy('mes')
            ->get()
            ->pluck('total', 'mes');

        // Promedio de calificaciones por mes
        $calificacionesPorMes = Report::whereYear('fechaQueja', $currentYear)
            ->selectRaw('MONTH(fechaQueja) as mes, AVG(calificacion) as promedio')
            ->groupBy('mes')
            ->orderBy('mes')
            ->get()
            ->pluck('promedio', 'mes');

        // Tasa de cierre por mes
        $cierrePorMes = Report::whereYear('fechaQueja', $currentYear)
            ->whereNotNull('fechaCierre')
            ->selectRaw('MONTH(fechaQueja) as mes, COUNT(*) as totalCerradas')
            ->groupBy('mes')
            ->orderBy('mes')
            ->get()
            ->pluck('totalCerradas', 'mes');

        // Preparar datos en formato legible para el frontend
        $meses = range(1, 12);
        $quejasData = [];
        $calificacionesData = [];
        $cierreData = [];

        foreach ($meses as $mes) {
            $quejasData[] = $quejasPorMes[$mes] ?? 0;
            $calificacionesData[] = round($calificacionesPorMes[$mes] ?? 0, 2);
            $cierreData[] = $cierrePorMes[$mes] ?? 0;
        }


        // Quiero que agreguemos lo siguiente:

        //Quejas por departamento: Gráfico de barras para mostrar cuántas quejas se registraron en cada departamento.


        //Calificaciones por departamento: Gráfico de barras para mostrar el promedio de calificaciones por departamento.

        //Departamentos con mayor número de quejas procedentes: Tabla o gráfico de barras que destaque los departamentos con el mayor porcentaje de quejas que procedieron.




        // Preparar datos para enviar a la vista
        return Inertia::render('Dashboard', [
            'totalReportes' => $totalReportes,
            'porcentajeProcedentes' => round($porcentajeProcedentes, 2),
            'calificacionPromedio' => round($calificacionPromedio),
            // 'calificacionPromedioDecimal' => round($calificacionPromedio, 2),
            'tiempoResolucion' => round($tiempoResolucion),
            // 'tiempoResolucion' => round($tiempoResolucion, 2),
            'quejasPorMes' => $quejasData,
            'calificacionesPorMes' => $calificacionesData,
            'cierrePorMes' => $cierreData,
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
