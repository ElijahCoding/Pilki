<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParticipateCountryTest extends TestCase
{
    use RefreshDatabase;

    protected $country;

    public function setUp()
    {
      parent::setUp();

      $this->country = create('App\Models\Country');
    }

    /** @test */
    public function a_guest_may_not_create_update_destroy_a_country()
    {
      $this->withExceptionHandling();

      $updatedCountry = 'Updated country name';

      $this->json('POST', 'api/crm/country' ,$this->country->toArray())
           ->assertStatus(401);

      $this->json('PATCH', "api/crm/country/{$this->country->id}" ,[
        'name' => $updatedCountry,
        'currency' => $this->country->currency
      ])->assertStatus(401);

      $this->json('DELETE', "api/crm/country/{$this->country->id}")->assertStatus(401);
    }

    /** @test */
    public function a_super_user_can_create_a_country()
    {
      $this->employerLogin();

      $this->json('POST', 'api/crm/country', $this->country->toArray());

      $this->assertDatabaseHas('countries', ['name' => json_encode($this->country->name)]);
    }

    /** @test */
    public function a_super_user_can_update_a_country()
    {
      $this->superUserLogin();

      $updatedCountry = 'Updated country name';

      $this->json('patch', "api/crm/country/{$this->country->id}", [
        'name' => $updatedCountry,
        'currency' => $this->country->currency
      ]);

      $this->assertDatabaseHas('countries', ['name' => json_encode($updatedCountry)]);

    }

    /** @test */
    public function a_super_user_can_destroy_a_country()
    {
      $this->superUserLogin();

      $this->json('DELETE', "api/crm/country/{$this->country->id}");

      $this->assertDatabaseMissing('countries', ['name' => json_encode($this->country->name)]);
    }
}
