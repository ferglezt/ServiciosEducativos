<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarrerasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('carreras', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 60);
            $table->string('nomenclatura', 5);
        });

        DB::table('carreras')->insert(array(
            array(
                'nombre' => 'INGENIERIA EN INFORMATICA',
                'nomenclatura' => 'IN'
            ),
            array(
                'nombre' => 'CIENCIAS DE LA INFORMATICA',
                'nomenclatura' => 'CI'
            ),
            array(
                'nombre' => 'INGENIERIA INDUSTRIAL',
                'nomenclatura' => 'II'
            ),
            array(
                'nombre' => 'ADMINISTRACION INDUSTRIAL',
                'nomenclatura' => 'AI'
            ),
            array(
                'nombre' => 'INGENIERIA EN TRANSPORTE',
                'nomenclatura' => 'IT'
            ),
            array(
                'nombre' => 'DESCONOCIDA',
                'nomenclatura' => 'N/A'
            )
        ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('carreras');
    }
}
