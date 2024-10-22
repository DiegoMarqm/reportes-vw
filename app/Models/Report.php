<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [

        'numFolio', //Este sera un numero de folio que tendran todos los reportes creados

        //Campos que estaran en el formulario principañ
        'departamento', //Es un select con el valor del departamento
        'calificacion', //Solo podemos recibir un numero de 1 a 5
        'fechaQueja', //Introducir la fecha de la queja
        'fechaEntrega', //Introducir la fecha de la queja, este campo puede ir vacio
        'fechaIngreso', //Este campo tambien puede ir vacio
        'formaDeteccion', //Es un select que recibe un value
        'redSocial', //Este es un campo que puede ir vacio
        'nomCliente', //Este campo recibe un nombre del cliente
        'celularCliente', //Este campo recibe el numero de telefono del cliente
        'emailCliente', // Este campo recibe el correo del cliente
        'asesor', //Un select que enviara el nombre del asesor
        'tipoModelo', //Un inputText que enviara el nomre del modelo de auto
        'placas', //Recibira las placas del auto, puede ir vacio
        'color', //Recibira el nombre del color del auto
        'noOrden', //Recibira el numero de orden
        'vin', //Recibira el VIN
        'tecnico', //Recibira el nombre del tecnico que arreglo
        'reclamacion', //Recibira el texto de la reclamacion que hizo el cliente
        'tipoReclamacion', //Esto sera un select
        'otroTipoReclamacion', //Esto sera un TextFiel que puede ir vacio o no
        'causaRaiz', //este sera un campo que tendra varia informacion dentro sera un $cast array
        'medidas', //Este sera un campo que tendra varia informacion dentro, tendra (medida, responsable, fecha) pero podremos almacenar agregar otra medida
        'procedeQueja', //Este tendra 2 radiobutton depende si seleccionas uno manda (Si o No) o mejor manejamos que puede ser true o false
        'solucion', //Recibe un texto donde se redacte la solucion que se le dio
        'nombreCierre', //Recibira el nombre del personal que cerro la reclamacion sera un Select con opciones
        'fechaCierre', //Recibira la fecha del cierre de la reclamacion
        'nombreSeguimiento', //Recibira el nomre del personal que realizo el contacto de seguimiento va a ser un select
        'fechaSeguimiento', //Recibira la fecha de cuando se hizo
        'comentariosCliente', //Recibira el texto del comentario que deho el cliente, puede estar vacio


        //Campos Extras que no van a estar en el formulario principal
        'evidenciasReporte', // Para almacenar archivos de evidencias puede ser Imagenes o archivos (Pueden subirse varios archivos a la vez)
        'reportePDF', // Para almacenar un archivo PDF
        'historialCambios', // Para guardar las fechas de cambios (JSON), estas fechas se agregaran automaticamente cuando se genere algun cambio en el todo el registro
        'estado', // Estado del reporte: abierto o cerrado recibe ya sea True o false, esto nos permitira habilitar o inabilitar el boton de editar

    ];

    protected $casts = [
        'historialCambios' => 'json', // Para almacenar el historial de cambios
        'causaRaiz' => 'array', // Para almacenar las causas raíz como array
        'medidas' => 'array', // Para almacenar las medidas como array
        'evidenciasReporte' => 'array', // Para almacenar múltiples archivos como array
        'procedeQueja' => 'boolean', // Para almacenar si la queja procede (Sí/No)
        'estado' => 'boolean', // Para almacenar el estado del reporte (abierto/cerrado)
    ];

    protected static function boot()
    {
        parent::boot();

        // Cuando se crea un nuevo registro
        static::creating(function ($report) {
            $historial = $report->historialCambios ?? [];

            $historial[] = [
                'cambios' => [
                    [
                        'campo' => 'registro',
                        'fecha' => now(),
                        'descripcion' => "El registro fue creado",
                    ]
                ],
                'fecha' => now(),
            ];

            $report->historialCambios = $historial;
        });

        static::updating(function ($report){
            $historial = $report->historialCambios ?? [];
            $cambios = [];
            foreach ($report->getDirty() as $campo => $valor){
                $cambios[] = [
                    'campo' => $campo,
                    'fecha' => now(),
                    // 'fecha' => now()->toDateTimeString()
                    'descricion' => sprintf("Campo '%s' se editó", $campo),
                ];
            }

            if(!empty($cambios)){
                $historial[] = [
                    'cambios' => $cambios,
                    'fecha' => now(),
                ];
            }

            $report->historialCambios = $historial;
        });
    }

}
