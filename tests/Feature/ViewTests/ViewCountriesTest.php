<?php

namespace Tests\Feature;

use Tests\ViewTests\ViewTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewCountriesTest extends ViewTestCase
{
    use RefreshDatabase;

    protected $country;

    public function setUp()
    {
      parent::setUp();

      $this->country = create('App\Models\Country');
    }

    /** @test */
    public function an_unauthenticated_user_may_not_view_countries_in_json_format()
    {
      $this->withExceptionHandling();

      $this->json('GET', '/api/crm/country')
           ->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_can_view_countries_in_json_format()
    {
        $this->employerLogin();

        $data = $this->fetchData('GET', '/api/crm/country');

        $this->assertEquals('success', $data['result']);

        $this->assertEquals($this->country->toArray(), $data['data']['items'][0]);
    }

    /** @test */
    public function an_unauthenticated_user_may_not_view_a_single_country_in_json_format()
    {
      $this->withExceptionHandling();

      $this->json('GET', '/api/crm/country/' . $this->country->id)
           ->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_can_view_a_single_country_in_json_format()
    {
        $this->employerLogin();

        $data = $this->fetchData('GET', '/api/crm/country/' . $this->country->id);

        $this->assertEquals('success', $data['result']);

        $this->assertEquals($this->country->toArray(), $data['data']);
    }
}
