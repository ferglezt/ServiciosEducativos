<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComprobantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comprobantes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 60);
        });

        DB::table('comprobantes')->insert(array(
            array(
                'nombre' => 'CONSTANCIA MUNICIPIO'
            ),
            array(
                'nombre' => 'CONSTANCIA DELEGACION'
            ),
            array(
                'nombre' => 'RECIBO NOMINA'
            ),
            array(
                'nombre' => 'CARTA EMPRESA'
            ),
            array(
                'nombre' => 'DECLARACION SAT'
            )
        ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comprobantes');
    }
}
