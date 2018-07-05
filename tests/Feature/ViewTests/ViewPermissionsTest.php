<?php

namespace Tests\Feature\ViewTests;

use App\Models\EmployerRelPermission;
use Tests\ViewTests\ViewTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewPermissionsTest extends ViewTestCase
{
  use RefreshDatabase;

  protected $permission;
  protected $permissionGroup;

  public function setUp()
  {
    parent::setUp();

    $this->permission = create('App\Models\Permission');

    $this->permissionGroup = create('App\Models\PermissionGroup');
  }

  /** @test */
  public function an_unauthenticated_employer_may_not_view_permissions_and_permission_groups_and_access_types()
  {
    $this->withExceptionHandling();

    $this->json('GET', 'api/crm/permission')
         ->assertStatus(401);

    $this->json('GET', 'api/crm/permission/groups')
        ->assertStatus(401);

    $this->json('GET', 'api/crm/permission/access_types')
        ->assertStatus(401);
  }

  /** @test */
  public function an_authenticated_employer_can_view_permissions()
  {
    $this->employerLogin();

    $data = $this->fetchData('GET', 'api/crm/permission');

    $this->assertEquals('success', $data['result']);

    $this->assertEquals($this->permission->all(['id', 'model', 'action', 'description'])->toArray()[0], $data['data']['items'][0]);
  }

  /** @test */
  public function an_authenticated_employer_can_view_permission_groups()
  {
    $this->employerLogin();

    $data = $this->fetchData('GET', 'api/crm/permission/groups');

    $this->assertEquals('success', $data['result']);

    $this->assertEquals($this->permissionGroup->toArray(), $data['data'][0]);
  }

  /** @test */
  public function an_authenticated_employer_can_view_access_types()
  {
    $this->employerLogin();
    
    $data = $this->fetchData('GET', 'api/crm/permission/access_types');

    $this->assertEquals('success', $data['result']);

    $this->assertEquals(EmployerRelPermission::$accessTypes, $data['data']);
  }
}
