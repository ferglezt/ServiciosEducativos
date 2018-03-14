<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicioSocialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicio_social', function(Blueprint $table) {
            $table->increments('id');
            $table->string('registro', 60)->unique();
            $table->string('consecutivo', 60)->nullable();
            $table->string('boleta', 60);
            $table->string('nombre', 300);
            $table->integer('carrera_id')->unsigned()->nullable();
            $table->enum('genero', ['M', 'F']);
            $table->string('prestatario', 300)->nullable();
            $table->string('programa', 100)->nullable();
            $table->string('profesor', 300)->nullable();
            $table->string('periodo', 60)->nullable();
            $table->string('tipo_ss', 10)->nullable();
            $table->integer('creditos')->unsigned()->nullable();
            $table->string('horario', 60)->nullable();
            $table->string('fecha_recepcion', 20)->nullable();
            $table->string('observaciones', 300)->nullable();
        });

        Schema::table('servicio_social', function($table) {
            $table->foreign('carrera_id')->references('id')->on('carreras')->onDelete('set null');
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
