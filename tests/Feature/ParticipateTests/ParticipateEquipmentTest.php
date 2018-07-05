<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParticipateEquipmentTest extends TestCase
{
  use RefreshDatabase;

  protected $equipment;

  public function setUp()
  {
    parent::setUp();

    $this->equipment = create('App\Models\Equipment');
  }

  /** @test */
  public function a_guest_may_not_create_update_destroy_an_equipment()
  {
    $this->withExceptionHandling();

    $updatedEquipment = 'Updated equipment title';

    $this->json('POST', 'api/crm/equipment' ,$this->equipment->toArray())
         ->assertStatus(401);

    $this->json('PATCH', "api/crm/equipment/{$this->equipment->id}" ,[
      'title' => $updatedEquipment,
    ])->assertStatus(401);

    $this->json('DELETE', "api/crm/equipment/{$this->equipment->id}")->assertStatus(401);
  }

  /** @test */
  public function a_super_user_can_create_an_equipment()
  {
    $this->employerLogin();

    $this->json('POST', 'api/crm/equipment', $this->equipment->toArray());

    $this->assertDatabaseHas('equipment', ['title' => $this->equipment->title]);
  }

  /** @test */
  public function a_super_user_can_update_an_equipment()
  {
    $this->superUserLogin();

    $updatedEquipment = 'Updated equipment title';

    $this->json('patch', "api/crm/equipment/{$this->equipment->id}", [
      'title' => $updatedEquipment,
    ]);

    $this->assertDatabaseHas('equipment', ['title' => $updatedEquipment]);
  }

  /** @test */
  public function a_super_user_can_destroy_an_equipment()
  {
    $this->superUserLogin();

    $this->json('DELETE', "api/crm/equipment/{$this->equipment->id}");

    $this->assertDatabaseMissing('equipment', ['title' => $this->equipment->title]);
  }
}
