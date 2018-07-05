<?php

use App\Models\Employer;
use App\Models\LegalEntity;
use App\Models\Unit;
use App\Models\UnitGroup;
use App\Models\WorkPosition;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class EmployerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {

        $first = true;
        for ($p = 0; $p < 50; $p++) {
            $employer = new Employer();

            $employer->legal_entity_id = LegalEntity::inRandomOrder()->first()->id;
            $employer->unit_id = Unit::where('legal_entity_id',
                $employer->legal_entity_id)->inRandomOrder()->first()->id;

            $employer->work_position_id = WorkPosition::where('legal_entity_id',
                $employer->legal_entity_id)->inRandomOrder()->first()->id;

            if ($first) {
                $employer->phone = '+71234567890';
                $employer->email = 'admin@test.ru';
                $first = false;
            } else {
                $employer->phone = '+7812' . rand(1000000, 9999999);
                $employer->email = $faker->unique()->safeEmail;
            }

            $employer->password = bcrypt('secret');
            $employer->first_name = $faker->firstName;
            $employer->last_name = $faker->lastName;
            $employer->schedule_type = array_random([
                Employer::SCHEDULE_TYPE_WINDOW_DEFAULT,
                Employer::SCHEDULE_TYPE_WINDOW_INDIVIDUAL,
            ]);

            $employer->status = Employer::STATUS_WORKED;

            $employer->save();

            $employer->permissions()->updateOrCreate([
                'permission_type' => WorkPosition::class,
                'permission_id'   => $employer->work_position_id,
                'access_type'     => array_random([Unit::class, UnitGroup::class, LegalEntity::class]),
                'access_id'       => rand(1, 10),
            ]);

            for ($i = 0; $i < 10; $i++) {
                if ($model = \App\Models\Service::query()->where('legal_entity_id',
                    $employer->legal_entity_id)->inRandomOrder()->first()) {
                    $employer->services()->syncWithoutDetaching([
                        $model->id => ['enabled' => true],
                    ]);
                }
            }

            for ($i = 0; $i < 5; $i++) {
                if ($model = \App\Models\ServiceCategory::query()->where('legal_entity_id',
                    $employer->legal_entity_id)->inRandomOrder()->first()) {
                    $employer->serviceCategories()->syncWithoutDetaching([
                        $model->id => ['enabled' => true],
                    ]);
                }
            }

        };
    }
}
