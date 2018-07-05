<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DistrictTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_district_belongs_to_a_city()
    {
      $city = create('App\Models\City');

      $district = create('App\Models\CityDistrict', ['city_id' => $city->id]);

      $this->assertInstanceOf('App\Models\City', $district->city);
    }
}
