<?php

namespace Tests\Feature\ParticipateTests;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParticipateEmployerTest extends TestCase
{
    use RefreshDatabase;

    protected $employer;

    public function setUp()
    {
      parent::setUp();

      $this->employer = create('App\Models\Employer', ['password' => bcrypt('secret')]);
    }

    /** @test */
    public function an_unauthenticated_user_may_not_create_update_destroy_an_employer()
    {
      $this->withExceptionHandling();

      $this->json('POST', '/api/crm/employers', $this->employer->toArray())
           ->assertStatus(401);

      $this->json('PATCH', '/api/crm/employers/' . $this->employer->id, $this->employer->toArray())
           ->assertStatus(401);

      $this->json('DELETE', '/api/crm/employers/' . $this->employer->id, $this->employer->toArray())
          ->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_can_update_an_employer()
    {
      $this->employerLogin();

      $this->assertDatabaseHas('employers', ['first_name' => $this->employer->first_name]);

      $updatedEmployerName = 'Updated employer name';

      $this->json('PATCH', 'api/crm/employers/' . $this->employer->id, [
        'first_name' => $updatedEmployerName,
      ]);


      $this->assertDatabaseHas('employers', ['first_name' => $updatedEmployerName]);
    }

    /** @test */
    public function an_authenticated_user_can_destroy_an_employer()
    {
      $this->employerLogin();

      $this->assertDatabaseHas('employers', ['first_name' => $this->employer->first_name]);

      $this->json('DELETE', '/api/crm/employers/' . $this->employer->id);

      $this->assertDatabaseMissing('employers', ['first_name' => $this->employer->first_name]);

    }

    /** @test */
    public function an_authenticated_user_can_create_an_employer()
    {
      $employer = $this->employerLogin();

      $this->json('GET', '/api/crm/employers', $employer->toArray());

      $this->assertDatabaseHas('employers', ['first_name' => $employer->first_name]);
      $this->assertDatabaseHas('employers', ['first_name' => $employer->first_name]);
    }
}
