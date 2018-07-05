<?php

use App\Models\WorkPosition;
use Illuminate\Database\Seeder;

class WorkPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::transaction(function () {
            $allWorkPositions = [
                'Супервизор',
                'Администратор системы',
                'Руководитель техподдержки',
                'Специалист техподдержки',
                'Управляющий салона',
                'Территориальный управляющий',
                'Управляющий сети',
                'Администратор студии',
                'Мастер',
                'Финансовый директор',
                'Старший бухгалтер',
                'Бухгалтер',
                'Руководитель колл-центра',
                'Старший оператор колл-центра',
                'Оператор колл-центра',
                'Руководитель контроля качества',
                'Специалист контроля качества',
                'Маркетолог',
                'Управляющим складом',
                'Начальник отдела кадров',
                'HR-специалист',
            ];

            for ($t = 0; $t < 20; $t++) {

                $workPosition = WorkPosition::create([
                    'legal_entity_id' => \App\Models\LegalEntity::inRandomOrder()->first()->id,
                    'title'           => array_random($allWorkPositions),
                ]);

                for ($i = 0; $i < 5; $i++) {
                    $permissionModel = array_random([
                        \App\Models\Permission::class,
                        \App\Models\PermissionGroup::class,
                    ]);

                    $workPosition->permissions()->updateOrCreate([
                        'permission_type' => $permissionModel,
                        'permission_id'   => $permissionModel::query()->inRandomOrder()->first()->id,
                    ]);
                }
            }

        });
    }
}
