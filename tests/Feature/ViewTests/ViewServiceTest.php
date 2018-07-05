<?php

namespace Tests\Feature;

use Tests\ViewTests\ViewTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewServiceTest extends ViewTestCase
{
    use RefreshDatabase;

    protected $service;

    public function setUp()
    {
      parent::setUp();

      $this->service = create('App\Models\Service');
    }

    /** @test */
    public function an_unauthenticated_user_may_not_view_any_services()
    {
      $this->withExceptionHandling();

      $this->json('GET', '/api/crm/service')
           ->assertStatus(401);

      $this->json('GET', '/api/crm/service/' . $this->service->id)
          ->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_can_view_services_in_json_format()
    {
        $this->employerLogin();

        $data = $this->fetchData('GET', '/api/crm/service');

        $this->assertEquals($this->service->toArray(), $data['data']['items'][0]);
    }

    /** @test */
    public function an_authenticated_user_can_view_a_single_service_in_json_format()
    {
        $this->employerLogin();

        $data = $this->fetchData('GET', '/api/crm/service/' . $this->service->id);

        $this->assertEquals('success', $data['result']);

        $this->assertEquals($this->service->toArray(), $data['data']);
    }
}
