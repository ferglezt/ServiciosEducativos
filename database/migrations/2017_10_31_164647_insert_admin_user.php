<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;

class InsertAdminUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('usuarios')->insert([
            [
                'nombre' => 'LORENA',
                'email' => 'sloren_77@hotmail.com',
                'password' => Hash::make('12345'),
                'rol_id' => 1
            ],
            [
                'nombre' => 'MARCELA ROJAS',
                'email' => 'marce_rojas2004@yahoo.com.mx',
                'password' => Hash::make('12345'),
                'rol_id' => 1
            ]

        ]);
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
