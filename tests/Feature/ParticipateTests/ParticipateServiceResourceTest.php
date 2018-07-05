<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParticipateServiceResourceTest extends TestCase
{
    use RefreshDatabase;

    protected $serviceResource;

    public function setUp()
    {
      parent::setUp();

      $this->serviceResource = create('App\Models\ServiceResource');
    }

    /** @test */
    public function a_guest_may_not_create_update_destroy_a_service_resource()
    {
      $this->withExceptionHandling();

      $updatedServiceResource = 'Updated service resource name';

      $this->json('POST', 'api/crm/service/resource' ,$this->serviceResource->toArray())
           ->assertStatus(401);

      $this->json('PATCH', "api/crm/service/resource/{$this->serviceResource->id}" ,[
        'title' => json_encode($updatedServiceResource),
      ])->assertStatus(401);

      $this->json('DELETE', "api/crm/service/resource/{$this->serviceResource->id}")
           ->assertStatus(401);
    }

    /** @test */
    public function a_super_user_can_create_a_service_resource()
    {
      $this->superUserLogin();

      $serviceResource = make('App\Models\ServiceResource');

      $request = $this->json('POST', 'api/crm/service/resource', [
        'legal_entity_id' => $serviceResource->legal_entity_id,
        'service_id' => $serviceResource->service_id,
        'type' => $serviceResource->type,
        'count' => $serviceResource->count
      ]);

      $this->assertDatabaseHas('service_resources', ['type' => $serviceResource->type]);
    }

    /** @test */
    public function a_super_user_can_update_a_service_resource()
    {
      $this->superUserLogin();

      $updatedType = 'new type';

      $request = $this->json('PATCH', "api/crm/service/resource/{$this->serviceResource->id}", [
        'legal_entity_id' => $this->serviceResource->legal_entity_id,
        'service_id' => $this->serviceResource->service_id,
        'type' => $updatedType,
        'count' => $this->serviceResource->count
      ]);

      $this->assertDatabaseHas('service_resources', ['type' => $updatedType]);
    }

    /** @test */
    public function a_super_user_can_destroy_a_service_resource()
    {
      $this->superUserLogin();

      $this->assertDatabaseHas('service_resources', ['type' => $this->serviceResource->type]);

      $this->json('DELETE', "api/crm/service/resource/{$this->serviceResource->id}");

      $this->assertDatabaseMissing('service_resources', ['type' => $this->serviceResource->type]);
    }
}
