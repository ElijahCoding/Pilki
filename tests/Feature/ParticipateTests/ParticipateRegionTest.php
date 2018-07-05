<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParticipateRegionTest extends TestCase
{
  use RefreshDatabase;

  protected $region;

  public function setUp()
  {
    parent::setUp();

    $this->region = create('App\Models\Region');
  }

  /** @test */
  public function a_guest_may_not_create_update_destroy_a_region()
  {
    $this->withExceptionHandling();

    $updatedRegion = 'Updated region name';

    $this->json('POST', 'api/crm/region' ,$this->region->toArray())
         ->assertStatus(401);

    $this->json('PATCH', "api/crm/region/{$this->region->id}" ,[
      'name' => $updatedRegion,
      'country_id' => $this->region->country_id
    ])->assertStatus(401);

    $this->json('DELETE', "api/crm/region/{$this->region->id}")->assertStatus(401);
  }

  /** @test */
  public function a_super_user_can_create_a_region()
  {
    $this->superUserLogin();

    $this->json('POST', 'api/crm/region', $this->region->toArray());

    $this->assertDatabaseHas('regions', ['name' => json_encode($this->region->name)]);
  }

  /** @test */
  public function a_super_user_can_update_a_region()
  {
    $this->superUserLogin();

    $updatedRegion = 'Updated region name';

    $this->json('patch', "api/crm/region/{$this->region->id}", [
      'name' => $updatedRegion,
      'country_id' => $this->region->country_id
    ]);

    $this->assertDatabaseHas('regions', ['name' => json_encode($updatedRegion)]);

  }

  /** @test */
  public function a_super_user_can_destroy_a_region()
  {
    $this->superUserLogin();

    $this->json('DELETE', "api/crm/region/{$this->region->id}");

    $this->assertDatabaseMissing('regions', ['id' => $this->region->id, 'name' => json_encode($this->region->name)]);
  }
}
