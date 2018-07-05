<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParticipateServiceCategoryTest extends TestCase
{
  use RefreshDatabase;

  protected $serviceCategory;

  public function setUp()
  {
    parent::setUp();

    $this->serviceCategory = create('App\Models\ServiceCategory');
  }

  /** @test */
  public function a_guest_may_not_create_update_destroy_a_service_category()
  {
    $this->withExceptionHandling();

    $updatedServiceCategory = 'Updated service category name';

    $this->json('POST', 'api/crm/service/category' , $this->serviceCategory->toArray())
         ->assertStatus(401);

    $this->json('PATCH', "api/crm/service/resource/{$this->serviceCategory->id}" ,[
      'title' => json_encode($updatedServiceCategory),
    ])->assertStatus(401);

    $this->json('DELETE', "api/crm/service/resource/{$this->serviceCategory->id}")
         ->assertStatus(401);
  }

  /** @test */
  public function a_super_user_can_create_a_service_category()
  {
    $this->superUserLogin();

    $request = $this->json('POST', 'api/crm/service/category', [
      'legal_entity_id' => $this->serviceCategory->legal_entity_id,
      'title' => $this->serviceCategory->title
    ]);

    $this->assertDatabaseHas('service_categories', ['title' => json_encode($this->serviceCategory->title)]);
  }

  /** @test */
  public function a_super_user_can_update_a_service_category()
  {
    $this->superUserLogin();

    $updatedTitle = 'updated title';

    $request = $this->json('PUT', "api/crm/service/category/{$this->serviceCategory->id}", [
      'legal_entity_id' => $this->serviceCategory->legal_entity_id,
      'title' => $updatedTitle
    ]);

    $this->assertDatabaseHas('service_categories', ['title' => json_encode($updatedTitle)]);
  }

  /** @test */
  public function a_super_user_can_destroy_a_service_category()
  {
    $this->superUserLogin();

    $this->assertDatabaseHas('service_categories', ['title' => json_encode($this->serviceCategory->title)]);

    $this->json('DELETE', "api/crm/service/category/{$this->serviceCategory->id}");

    $this->assertDatabaseMissing('service_categories', ['title' => json_encode($this->serviceCategory->title)]);
  }
}
