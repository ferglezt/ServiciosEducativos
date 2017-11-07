<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitudsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('anio')->unsigned();
            $table->integer('folio')->unsigned();
            $table->string('etiqueta', 60)->nullable();
            $table->integer('estudiante_id')->unsigned();
            $table->integer('semestre')->unsigned()->nullable();
            $table->decimal('promedio', 18, 5)->nullable();
            $table->string('estatus_estudiante', 20)->nullable();
            $table->integer('carga')->unsigned()->nullable();
            $table->string('estatus_becario', 20)->nullable();
            $table->string('beca_anterior', 30)->nullable();
            $table->string('beca_solicitada', 30)->nullable();
            $table->string('folio_manutencion', 30)->nullable();
            $table->string('folio_transporte', 30)->nullable();
            $table->string('comprobante_ingresos', 60)->nullable();
            $table->string('mapa', 60)->nullable();
            $table->string('fecha_recibido', 20)->nullable();
            $table->decimal('ingresos', 18, 10)->nullable();
            $table->integer('dependientes')->unsigned()->nullable();
            $table->text('observaciones')->nullable();
        });

        Schema::table('solicitudes', function($table) {
            $table->foreign('estudiante_id')->references('id')->on('estudiantes')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('solicitudes');
    }
}
