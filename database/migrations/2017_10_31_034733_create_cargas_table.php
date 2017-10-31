<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCargasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cargas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('carrera_id')->unsigned();
            $table->integer('carga_minima')->unsigned();
            $table->integer('carga_media')->unsigned();
            $table->integer('carga_maxima')->unsigned();
        });

        Schema::table('cargas', function($table) {
            $table->foreign('carrera_id')->references('id')->on('carreras')->onDelete('cascade');
        });

        DB::table('cargas')->insert(array(
            array(
                'carrera_id' => 1,
                'carga_minima' => 6,
                'carga_media' => 8,
                'carga_maxima' => 11 
            ),
            array(
                'carrera_id' => 2,
                'carga_minima' => 5,
                'carga_media' => 7,
                'carga_maxima' => 10 
            ),
            array(
                'carrera_id' => 3,
                'carga_minima' => 7,
                'carga_media' => 9,
                'carga_maxima' => 12 
            ),
            array(
                'carrera_id' => 4,
                'carga_minima' => 5,
                'carga_media' => 8,
                'carga_maxima' => 11 
            ),
            array(
                'carrera_id' => 5,
                'carga_minima' => 6,
                'carga_media' => 8,
                'carga_maximaga' => 11 
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
        Schema::dropIfExists('cargas');
    }
}
