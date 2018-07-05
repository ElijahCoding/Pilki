<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CountryTest extends TestCase
{
    use RefreshDatabase;

    protected $country;

    public function setUp()
    {
      parent::setUp();
      $this->country = create('App\Models\Country');
    }

    /** @test */
    public function a_country_has_many_regions()
    {
      $region = create('App\Models\Region', ['country_id' => $this->country->id]);

      $this->assertTrue($this->country->regions->contains($region));
    }
}
