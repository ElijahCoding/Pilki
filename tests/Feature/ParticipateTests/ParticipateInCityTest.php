<?php

namespace Tests\Feature;

use App\Models\{
    Employer, City
};
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParticipateInCityTest extends TestCase
{
    use RefreshDatabase;

    protected $city;

    public function setUp()
    {
        parent::setUp();

        $this->city = create('App\Models\City');
    }

    /** @test */
    public function a_guest_may_not_create_update_destroy_a_city()
    {
        $this->withExceptionHandling();

        $updatedCity = 'Updated city name';

        $this->json('POST', 'api/crm/city', $this->city->toArray())
             ->assertStatus(401);

        $this->json('PATCH', "api/crm/city/{$this->city->id}" ,[
          'name' => $updatedCity,
          'region_id' => $this->city->region_id
        ])->assertStatus(401);

        $this->json('DELETE', "api/crm/city/{$this->city->id}")->assertStatus(401);
    }

    /** @test */
    public function a_super_user_can_create_a_city()
    {
        $this->superUserLogin();

        $this->json('POST', 'api/crm/city', $this->city->toArray());

        $this->assertDatabaseHas('cities', ['name' => json_encode($this->city->name)]);
    }

    /** @test */
    public function a_super_user_can_update_a_city()
    {
        $this->superUserLogin();

        $updatedCity = 'Updated city name';

        $this->json('patch', "api/crm/city/{$this->city->id}", [
            'region_id' => $this->city->region_id,
            'name'      => $updatedCity,
        ]);

        $this->assertDatabaseHas('cities', ['name' => json_encode($updatedCity)]);

    }

    /** @test */
    public function a_guest_may_not_destroy_a_city()
    {
      $this->withExceptionHandling();

      $this->json('DELETE', "api/crm/city/{$this->city->id}")
           ->assertStatus(401);
    }

    /** @test */
    public function a_super_user_can_destroy_a_city()
    {
      $this->superUserLogin();

      $this->json('DELETE', "api/crm/city/{$this->city->id}");

      $this->assertDatabaseMissing('cities', ['id' => $this->city->id, 'name' => json_encode($this->city->name)]);
    }
}
