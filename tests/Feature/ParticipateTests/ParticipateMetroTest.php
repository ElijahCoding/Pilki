<?php

namespace Tests\Feature\ParticipateTests;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParticipateMetroTest extends TestCase
{
    use RefreshDatabase;

    protected $metro;

    public function setUp()
    {
        parent::setUp();

        $this->metro = create('App\Models\Metro');
    }

    /** @test */
    public function a_guest_may_not_create_update_destroy_a_metro()
    {
        $this->withExceptionHandling();

        $updatedMetro = 'Updated Vosstania';

        $this->json('POST', 'api/crm/metro', $this->metro->toArray())
             ->assertStatus(401);

        $this->json('PATCH', "api/crm/metro/{$this->metro->id}" ,[
          'name' => $updatedMetro,
          'city_id' => $this->metro->city_id
        ])->assertStatus(401);

        $this->json('DELETE', "api/crm/metro/{$this->metro->id}")->assertStatus(401);
    }

    /** @test */
    public function a_super_user_can_create_a_metro()
    {
      $this->employerLogin();

      $this->json('POST', 'api/crm/metro', $this->metro->toArray());

      $this->assertDatabaseHas('metros', ['name' => json_encode($this->metro->name)]);
    }


    /** @test */
    public function a_super_user_can_destroy_a_metro()
    {
      $this->employerLogin();

      $this->json('DELETE', "api/crm/metro/{$this->metro->id}");

      $this->assertDatabaseMissing('metros', ['id' => $this->metro->id, 'name' => json_encode($this->metro->name)]);
    }
}
