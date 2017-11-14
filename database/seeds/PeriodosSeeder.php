<?php

use Illuminate\Database\Seeder;

class PeriodosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('periodos')->insert([
        	['anio' => 2018, 'periodo' => 2]
        ]);

        for($i = 2019; $i < 2030; $i++) {
        	for($j = 1; $j <=2; $j++) {
        		DB::table('periodos')->insert([
        			['anio' => $i, 'periodo' => $j]
        		]);
        	}
        }
    }
}
