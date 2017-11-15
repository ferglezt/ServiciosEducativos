<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIngresoMinimosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingreso_minimo', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('ingreso_minimo_por_persona', 18, 5);
        });

        DB::table('ingreso_minimo')->insert([
            ['ingreso_minimo_por_persona' => 643.67]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ingreso_minimo');
    }
}
