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
            $table->integer('periodo_id')->unsigned();
            $table->integer('folio')->unsigned();
            $table->string('etiqueta', 20);
            $table->integer('estudiante_id')->unsigned();
            $table->enum('semestre_estudiante', [1, 2, 3, 4, 5, 6, 7, 8]);
            $table->decimal('promedio_estudiante', 2, 2);
            $table->enum('estatus_estudiante', ['REGULAR', 'IRREGULAR']);
            $table->integer('carga')->unsigned();
            $table->enum('estatus_becario', ['ASPIRANTE', 'REVALIDANTE']);
            $table->integer('beca_anterior_id')->unsigned()->nullable();
            $table->integer('beca_solicitada_id')->unsigned();
            $table->integer('folio_manutencion')->unsigned()->nullable();
            $table->integer('folio_transporte')->unsigned()->nullable();
            $table->date('fecha_recibido');
            $table->decimal('ingresos', 6, 2);
            $table->integer('dependientes')->unsigned();
            $table->text('observaciones')->nullable();
        });

        Schema::table('solicitudes', function($table) {
            $table->foreign('periodo_id')->references('id')->on('periodos')->onDelete('cascade');
            $table->foreign('beca_anterior_id')->references('id')->on('becas')->onDelete('set null');
            $table->foreign('beca_solicitada_id')->references('id')->on('becas')->onDelete('cascade');
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
