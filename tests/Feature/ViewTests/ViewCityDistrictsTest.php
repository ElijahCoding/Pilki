<?php

namespace Tests\Feature;

use Tests\ViewTests\ViewTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewCityDistrictsTest extends ViewTestCase
{
  use RefreshDatabase;

  protected $district;

  public function setUp()
  {
    parent::setUp();

    $this->district = create('App\Models\CityDistrict');
  }

  /** @test */
  public function an_unauthenticated_user_may_not_view_city_districts_in_json_format()
  {
    $this->withExceptionHandling();

    $this->json('GET', '/api/crm/district')
         ->assertStatus(401);
  }

  /** @test */
  public function an_authenticated_user_can_view_city_districts_in_json_format()
  {
      $this->employerLogin();

      $data = $this->fetchData('GET', '/api/crm/district');

      $this->assertEquals('success', $data['result']);

      $this->assertEquals($this->district->toArray(), $data['data']['items'][0]);
  }
}
