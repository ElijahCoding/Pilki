<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParticipateCityDistrictTest extends TestCase
{
  use RefreshDatabase;

  protected $district;

  public function setUp()
  {
    parent::setUp();

    $this->district = create('App\Models\CityDistrict');
  }

  /** @test */
  public function a_guest_may_not_create_update_destroy_a_city_district()
  {
    $this->withExceptionHandling();

    $updatedDistrict = 'Updated district name';

    $this->json('POST', 'api/crm/district' ,$this->district->toArray())
         ->assertStatus(401);

    $this->json('PATCH', "api/crm/district/{$this->district->id}" ,[
      'name' => $updatedDistrict,
      'city_id' => $this->district->city_id
      ])->assertStatus(401);
  }

  /** @test */
  public function a_super_user_can_create_a_city_district()
  {
    $this->employerLogin();

    $this->json('POST', 'api/crm/district', $this->district->toArray());

    $this->assertDatabaseHas('city_districts', ['name' => $this->district->name]);
  }

  /** @test */
  public function a_super_user_can_destroy_a_district()
  {
    $this->employerLogin();

    $this->assertDatabaseHas('city_districts', ['id' => $this->district->id, 'name' => $this->district->name]);

    $this->json('DELETE', "api/crm/district/{$this->district->id}")->assertStatus(200);

    // $this->assertDatabaseMissing('city_districts', ['id' => $this->district->id]);
  }
}
