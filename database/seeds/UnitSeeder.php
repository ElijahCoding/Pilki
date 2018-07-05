<?php


use App\Models\City;
use App\Models\CityDistrict;
use App\Models\Unit;
use App\Models\UnitGroup;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
//        $faker = new Faker();

        for ($i = 0; $i < 100; $i++) {
            /** @var City|CityDistrict $locationModel */
            $locationModel = array_random([City::class]);

            Unit::create([
                'name'            => $faker->company,
                'location_type'   => $locationModel,
                'location_id'     => $locationModel::inRandomOrder()->first()->id,
                'legal_entity_id' => \App\Models\LegalEntity::inRandomOrder()->first()->id,
                'address'         => $faker->address,
                'latitude'        => $faker->latitude,
                'longitude'       => $faker->longitude,
            ]);
        }

        factory(\App\Models\UnitGroup::class, 10)->create()->each(function (UnitGroup $unitGroup) {
            $ids = [
                rand(1, 10),
                rand(11, 20),
                rand(21, 30),
                rand(31, 40),
                rand(41, 50),
                rand(51, 60),
                rand(61, 70),
                rand(71, 80),
                rand(81, 90),
                rand(91, 100),
            ];
            $unitGroup->units()->attach($ids);
        });
    }
}