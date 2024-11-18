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
        Schema::table('reports', function (Blueprint $table) {

            $table->text('solucion')->nullable()->change(); // Cambia el campo a nullable
            $table->string('nombreCierre')->nullable()->change(); // Cambia el campo a nullable
            $table->date('fechaCierre')->nullable()->change(); // Cambia el campo a nullable
            $table->string('nombreSeguimiento')->nullable()->change(); // Cambia el campo a nullable
            $table->date('fechaSeguimiento')->nullable()->change(); // Cambia el campo a nullable


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {

            $table->text('solucion')->nullable(false)->change(); // Regresa a no nullable si es necesario
            $table->string('nombreCierre')->nullable(false)->change(); // Regresa a no nullable si es necesario
            $table->date('fechaCierre')->nullable(false)->change(); // Regresa a no
            $table->string('nombreSeguimiento')->nullable(false)->change(); // Regresa a no nullable si es necesario
            $table->date('fechaSeguimiento')->nullable(false)->change(); // Regresa a no nullable si es necesario
            
        });
    }
};
