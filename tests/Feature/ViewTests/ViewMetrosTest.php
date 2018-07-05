<?php

namespace Tests\Feature\ViewTests;

use Tests\ViewTests\ViewTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewMetrosTest extends ViewTestCase
{
    use RefreshDatabase;

    protected $metro;

    public function setUp()
    {
      parent::setUp();

      $this->metro = create('App\Models\Metro');
    }

    /** @test */
    public function an_unauthenticated_user_may_not_view_metros_in_json_format()
    {
      $this->withExceptionHandling();

      $this->json('GET', '/api/crm/metro')
           ->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_can_view_metros_in_json_format()
    {
        $this->employerLogin();

        $data = $this->fetchData('GET', '/api/crm/metro');

        $this->assertEquals('success', $data['result']);

        $this->assertEquals($this->metro->toArray(), $data['data']['items'][0]);
    }
}
