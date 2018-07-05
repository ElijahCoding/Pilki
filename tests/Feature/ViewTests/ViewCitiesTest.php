<?php

namespace Tests\Feature;

use Tests\ViewTests\ViewTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewCitiesTest extends ViewTestCase
{
  use RefreshDatabase;

  protected $city;

  public function setUp()
  {
    parent::setUp();

    $this->city = create('App\Models\City');
  }

  /** @test */
  public function an_unauthenticated_user_may_not_view_cities_in_json_format()
  {
    $this->withExceptionHandling();

    $this->json('GET', '/api/crm/city')
         ->assertStatus(401);
  }

  /** @test */
  public function an_authenticated_user_can_view_cities_in_json_format()
  {
      $this->employerLogin();

      $data = $this->fetchData('GET', '/api/crm/city');

      $this->assertEquals('success', $data['result']);

      $this->assertEquals($this->city->toArray(), $data['data']['items'][0]);
  }
}
