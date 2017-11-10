<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSolicitudEstatusColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('solicitudes', function($table) {
            $table->enum('estatus_solicitud', [
                'PENDIENTE', 'ACEPTADO', 'RECHAZADO', 'LISTA DE ESPERA'
            ])->default('PENDIENTE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
