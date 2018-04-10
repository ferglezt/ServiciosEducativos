<?php

use Illuminate\Database\Seeder;

class OlderPeriodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 2000; $i < 2018; $i++) {
        	for($j = 1; $j <=2; $j++) {
        		DB::table('periodos')->insert([
        			['anio' => $i, 'periodo' => $j]
        		]);
        	}
        }
    }
}
