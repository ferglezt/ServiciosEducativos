<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstudiantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('boleta', 100)->unique();
            $table->string('nombre', 300);
            $table->integer('carrera_id')->unsigned()->nullable();
            $table->string('curp', 20);
            $table->string('email', 191)->nullable();
            $table->string('telefono', 20)->nullable();
            $table->enum('genero', ['M', 'F']);
            $table->string('oriundo', 60)->nullable();

        });

        Schema::table('estudiantes', function ($table) {
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
        Schema::dropIfExists('estudiantes');
    }
}
