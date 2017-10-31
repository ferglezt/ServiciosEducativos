<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBecasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('becas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 60);
        });

        DB::table('becas')->insert(array(
            array(
                'nombre' => 'INSTITUCIONAL'
            ),
            array(
                'nombre' => 'MANUTENCION'
            ),
            array(
                'nombre' => 'HARP HELU'
            ),
            array(
                'nombre' => 'TELMEX'
            ),
            array(
                'nombre' => 'BECALOS'
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
        Schema::dropIfExists('becas');
    }
}
