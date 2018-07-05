<?php

namespace Tests\Unit\ModelTests;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PermissionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_permission_belongs_to_many_permission_groups()
    {
      $permission = create('App\Models\Permission');

      $permissionGroup = create('App\Models\PermissionGroup');

      $permission->permissionGroups()->attach($permissionGroup);

      $this->assertDatabaseHas(
        'permission_rel_permission_groups',
        ['permission_group_id' => $permissionGroup->id, 'permission_id' => $permission->id]
      );
    }

    /** @test */
    public function a_permission_is_only_plucking_out_id_model_action_and_description()
    {
      $output = [
        'model',
        'action',
        'description',
        'updated_at',
        'created_at',
        'id'
      ];

      $permission = create('App\Models\Permission');

      $this->assertEquals(array_keys($permission->toArray()), $output);
    }
}
