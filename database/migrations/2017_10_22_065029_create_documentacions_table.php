<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentacion', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('solicitud_id')->unsigned();
            $table->boolean('estudio_socioeconomico')->nullable();
            $table->boolean('curp')->nullable();
            $table->boolean('comprobante_domicilio')->nullable();
            $table->boolean('constancia_inscripcion')->nullable();
            $table->boolean('carta_compromiso')->nullable();
            $table->boolean('kardex')->nullable();
            $table->boolean('formato_ingresos_egresos')->nullable();
            $table->boolean('comprobante_ingresos')->nullable();
            $table->boolean('credencial_elector')->nullable();
            $table->boolean('ficha_inscripcion')->nullable();
            $table->boolean('certificado_nivel_medio')->nullable();
            $table->boolean('transporte_estudio_socioeconomico');
            $table->boolean('manutencion_acuse')->nullable();
            $table->boolean('transporte_subes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documentacion');
    }
}
