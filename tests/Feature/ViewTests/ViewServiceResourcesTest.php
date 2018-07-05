<?php

namespace Tests\Feature;

use Tests\ViewTests\ViewTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewServiceResourcesTest extends ViewTestCase
{
  use RefreshDatabase;

  protected $serviceResource;

  public function setUp()
  {
    parent::setUp();

    $this->serviceResource = create('App\Models\ServiceResource');
  }

  /** @test */
  public function an_unauthenticated_user_may_not_view_any_service_resources()
  {
    $this->withExceptionHandling();

    $this->json('GET', '/api/crm/service/resource')
         ->assertStatus(401);

    $this->json('GET', '/api/crm/service/resource' . $this->serviceResource->id)
        ->assertStatus(401);
  }

  /** @test */
  public function an_authenticated_user_can_view_service_resources_in_json_format()
  {
      $this->employerLogin();

      $data = $this->fetchData('GET', '/api/crm/service/resource');

      $this->assertEquals($this->serviceResource->toArray(), $data['data']['items'][0]);
  }

  /** @test */
  public function an_authenticated_user_can_view_a_single_service_resource_in_json_format()
  {
      $this->employerLogin();

      $data = $this->fetchData('GET', '/api/crm/service/resource/' . $this->serviceResource->id);

      $this->assertEquals('success', $data['result']);

      $this->assertEquals($this->serviceResource->toArray(), $data['data']);
  }
}
