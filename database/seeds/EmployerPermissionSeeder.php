<?php

use App\Models\Employer;
use App\Models\LegalEntity;
use App\Models\Permission;
use App\Models\Unit;
use App\Models\UnitGroup;
use Illuminate\Database\Seeder;

class EmployerPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $employer = Employer::find(1);

        foreach (Permission::all() as $permission) {
            for ($i = 0; $i < 10; $i++) {
                $employer->permissions()->updateOrCreate([
                    'permission_type' => Permission::class,
                    'permission_id'   => $permission->id,
                    'access_type'     => array_random([Unit::class, UnitGroup::class, LegalEntity::class]),
                    'access_id'       => rand(1, 10),
                ]);
            }
        }

    }
}
