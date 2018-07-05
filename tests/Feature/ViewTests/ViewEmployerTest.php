<?php

namespace Tests\Feature;

use App\Models\Employer;
use Tests\ViewTests\ViewTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewEmployerTest extends ViewTestCase
{
    use RefreshDatabase;

    protected $employer;

    public function setUp()
    {
      parent::setUp();

      $this->employer = create('App\Models\Employer');
    }

    /** @test */
    public function an_unauthenticated_user_may_not_view_employers_in_json_format()
    {
      $this->withExceptionHandling();

      $this->json('GET', '/api/crm/employers')
           ->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_can_view_employers_in_json_format()
    {
      $this->employerLogin();

      $data = $this->fetchData('GET', '/api/crm/employers');

      $this->assertEquals('success', $data['result']);

      $this->assertEquals($this->employer->first_name, $data['data']['items'][0]['first_name']);
    }

    /** @test */
    public function an_unauthenticated_user_may_not_view_a_single_employer_in_json_format()
    {
      $this->withExceptionHandling();

      $this->json('GET', '/api/crm/employers/' . $this->employer->id)
           ->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_can_view_a_single_employer_in_json_format()
    {
      $this->employerLogin();

      $data = $this->fetchData('GET', '/api/crm/employers/' . $this->employer->id);

      $this->assertEquals('success', $data['result']);

      $this->assertEquals($this->employer->first_name, $data['data']['first_name']);
    }

}
