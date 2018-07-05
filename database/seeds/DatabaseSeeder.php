<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LegalEntitySeeder::class);
        $this->call(ServiceCategorySeeder::class);
        $this->call(ServiceSeeder::class);


        $this->call(LocationSeeder::class);

        $this->call(ServiceSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(UnitSeeder::class);
        $this->call(WorkPositionSeeder::class);
        $this->call(EmployerSeeder::class);
        $this->call(EmployerPermissionSeeder::class);


    }
}
