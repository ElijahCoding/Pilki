<?php

namespace Tests\Feature;

use Tests\ViewTests\ViewTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewEquipmentTest extends ViewTestCase
{
  use RefreshDatabase;

  protected $equipment;

  public function setUp()
  {
    parent::setUp();

    $this->equipment = create('App\Models\Equipment');
  }

  /** @test */
  public function an_unauthenticated_user_may_not_view_any_equipment_in_json_format()
  {
    $this->withExceptionHandling();

    $this->json('GET', '/api/crm/equipment')
         ->assertStatus(401);

    $this->json('GET', '/api/crm/equipment/' . $this->equipment->id)
        ->assertStatus(401);
  }

  /** @test */
  public function an_authenticated_user_can_view_equipments_in_json_format()
  {
      $this->employerLogin();

      $data = $this->fetchData('GET', '/api/crm/equipment');

      $this->assertEquals($this->equipment->toArray(), $data['data']['items'][0]);
  }

  /** @test */
  public function an_authenticated_user_can_view_a_single_equipment_in_json_format()
  {
      $this->employerLogin();

      $data = $this->fetchData('GET', '/api/crm/equipment/' . $this->equipment->id);

      $this->assertEquals('success', $data['result']);

      $this->assertEquals($this->equipment->toArray(), $data['data']);
  }
}
