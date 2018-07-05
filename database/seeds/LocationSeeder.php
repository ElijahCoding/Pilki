<?php

use Illuminate\Database\Seeder;


class LocationSeeder extends Seeder
{

    public function __construct()
    {

    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Artisan::call('fixture:import', [
            'tables'     => 'countries,regions,cities,city_districts,metros',
            '--truncate' => true,
        ]);
    }
}
