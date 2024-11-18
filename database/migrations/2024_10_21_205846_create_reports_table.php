<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {

            $table->id(); // ID autoincremental
            $table->string('numFolio')->unique(); // Número de folio único
            $table->string('departamento')->index(); // Departamento del reporte
            $table->integer('calificacion')->index(); // Calificación de 1 a 5
            $table->date('fechaQueja')->index(); // Fecha de la queja
            $table->date('fechaEntrega')->nullable(); // Fecha de entrega, puede ser nula
            $table->date('fechaIngreso')->nullable(); // Fecha de ingreso, puede ser nula
            $table->string('formaDeteccion')->index(); // Forma de detección (select)
            $table->string('redSocial')->nullable(); // Red social, puede ser nula
            $table->string('nomCliente'); // Nombre del cliente
            $table->string('celularCliente'); // Número de celular del cliente
            $table->string('emailCliente'); // Correo electrónico del cliente
            $table->string('asesor')->index(); // Nombre del asesor (select)
            $table->string('tipoModelo'); // Modelo del auto
            $table->string('placas')->nullable(); // Placas del auto, pueden ser nulas
            $table->string('color'); // Color del auto
            $table->string('noOrden'); // Número de orden
            $table->string('vin'); // Número de identificación del vehículo (VIN)
            $table->string('tecnico'); // Nombre del técnico
            $table->text('reclamacion'); // Texto de la reclamación
            $table->string('tipoReclamacion'); // Tipo de reclamación (select)
            $table->string('otroTipoReclamacion')->nullable(); // Otro tipo de reclamación, puede ser nulo
            $table->json('causaRaiz')->nullable(); // Causa raíz (array JSON)
            $table->json('medidas'); // Medidas (array JSON)
            $table->boolean('procedeQueja')->index(); // Si procede la queja o no (boolean)
            $table->text('solucion')->nullable(); // Texto con la solución del reporte
            $table->string('nombreCierre')->nullable(); // Nombre del personal que cerró la reclamación
            $table->date('fechaCierre')->index()->nullable(); // Fecha de cierre de la reclamación
            $table->string('nombreSeguimiento')->nullable(); // Nombre del personal de seguimiento
            $table->date('fechaSeguimiento')->nullable(); // Fecha del seguimiento
            $table->text('comentariosCliente')->nullable(); // Comentarios del cliente, puede ser nulo


            // Campos extras
            $table->json('evidenciasReporte'); // Evidencias (array JSON de archivos)
            $table->string('reportePDF')->nullable(); // Archivo PDF del reporte
            $table->json('historialCambios'); // Historial de cambios (array JSON)
            $table->boolean('estado'); // Estado del reporte (Activo = True / Inactivo = False)
            $table->timestamps(); // created_at y updated_at

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
