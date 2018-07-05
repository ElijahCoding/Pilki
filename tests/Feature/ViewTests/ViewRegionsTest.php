<?php

namespace Tests\Feature;

use Tests\ViewTests\ViewTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewRegionsTest extends ViewTestCase
{
  use RefreshDatabase;

  protected $region;

  public function setUp()
  {
    parent::setUp();

    $this->region = create('App\Models\Region');
  }

  /** @test */
  public function an_unauthenticated_user_may_not_view_regions_in_json_format()
  {
    $this->withExceptionHandling();

    $this->json('GET', '/api/crm/region')
         ->assertStatus(401);
  }

  /** @test */
  public function an_authenticated_user_can_view_regions_in_json_format()
  {
      $this->employerLogin();

      $data = $this->fetchData('GET', '/api/crm/region');

      $this->assertEquals('success', $data['result']);

      $this->assertEquals($this->region->toArray(), $data['data']['items'][0]);
  }

}
