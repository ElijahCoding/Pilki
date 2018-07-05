<?php

namespace Tests\Unit\ModelTests;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PermissionGroupTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_permission_group_belongs_to_many_permissions()
    {
      $permission = create('App\Models\Permission');

      $permissionGroup = create('App\Models\PermissionGroup');

      $permissionGroup->permissions()->attach($permission);

      $this->assertDatabaseHas(
        'permission_rel_permission_groups',
        ['permission_group_id' => $permissionGroup->id, 'permission_id' => $permission->id]
      );
    }
}
