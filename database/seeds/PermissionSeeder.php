<?php

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{

    protected $actions = [
        'update'       => 'Редактирование',
        'view'         => 'Просмотр',
        'create_child' => 'Создание дочерних',
        'delete'       => 'Удаление',
    ];

    protected $models = [
        \App\Models\Unit::class         => 'Салоны',
        \App\Models\LegalEntity::class  => 'Юр. лицо',
        \App\Models\Employer::class     => 'Сотрудники',
        \App\Models\Equipment::class    => 'Оборудование',
        \App\Models\WorkPosition::class => 'Должности',
    ];

    protected $modelActions = [
        \App\Models\Employer::class  => [
            'schedule.approve' => 'Расписание. Подтверждение',
            'services.control' => 'Услуги. Управление',
        ],
        \App\Models\Equipment::class => [
            'services.control' => 'Услуги. Управление',
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->models as $model => $modelName) {
            foreach ($this->actions + ($this->modelActions[$model] ?? []) as $action => $actionName) {
                Permission::updateOrCreate([
                    'model'  => $model,
                    'action' => $action,
                ], ['description' => $modelName . '. ' . $actionName]);
            }
        }

        $permissionGroup = \App\Models\PermissionGroup::create([
            'title' => 'Все права',
        ]);

        $permissionGroup->permissions()->attach(Permission::all());
    }

    public function getModels()
    {
        return array_keys($this->models);
    }
}
