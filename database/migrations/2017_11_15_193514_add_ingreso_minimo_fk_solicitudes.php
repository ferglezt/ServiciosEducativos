<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIngresoMinimoFkSolicitudes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('solicitudes', function($table) {
            $table->integer('ingreso_minimo_id')->unsigned()->nullable();
            $table->foreign('ingreso_minimo_id')->references('id')->on('ingreso_minimo')->onDelete('set null');
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
