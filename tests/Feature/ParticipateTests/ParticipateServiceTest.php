<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParticipateServiceTest extends TestCase
{
  use RefreshDatabase;

  protected $service;

  public function setUp()
  {
    parent::setUp();

    $this->service = create('App\Models\Service');
  }

  /** @test */
  public function a_guest_may_not_create_update_destroy_a_service()
  {
    $this->withExceptionHandling();

    $updatedService = 'Updated service name';

    $this->json('POST', 'api/crm/service' ,$this->service->toArray())
         ->assertStatus(401);

    $this->json('PATCH', "api/crm/service/{$this->service->id}" ,[
      'title' => $updatedService,
    ])->assertStatus(401);

    $this->json('DELETE', "api/crm/service/{$this->service->id}")
         ->assertStatus(401);
  }

  /** @test */
  public function a_super_user_can_create_a_service()
  {
    $this->superUserLogin();

    $this->json('POST', 'api/crm/service', $this->service->toArray());

    $this->assertDatabaseHas('services', ['title' => json_encode($this->service->title)]);
  }

  /** @test */
  public function a_super_user_can_update_a_service()
  {
    $this->superUserLogin();

    $updatedService = 'UpdatedService';

    $this->json('PUT', "api/crm/service/{$this->service->id}", [
      'service_category_id' => $this->service->service_category_id,
      'article' => json_encode($this->service->article),
      'title' => $updatedService,
      'title_online' => json_encode($this->service->title_online),
      'title_cashier' => json_encode($this->service->title_cashier)
    ]);

    $this->assertDatabaseHas('services', ['title' => json_encode($updatedService)]);
  }

  /** @test */
  public function a_super_user_can_destroy_a_service()
  {
    $this->superUserLogin();

    $this->assertDatabaseHas('services', ['title' => json_encode($this->service->title)]);

    $this->json('DELETE', "api/crm/service/{$this->service->id}");
    //
    $this->assertDatabaseMissing('services', ['title' => json_encode($this->service->title)]);
  }
}
