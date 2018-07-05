<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_city_belongs_to_a_region()
    {
      $region = create('App\Models\Region');

      $city = create('App\Models\City', ['region_id' => $region->id]);

      $this->assertInstanceOf('App\Models\Region', $city->region);
    }

    /** @test */
    public function a_city_has_many_districts()
    {
      $city = create('App\Models\City');

      $district = create('App\Models\CityDistrict', ['city_id' => $city->id]);

      $this->assertTrue($city->cityDistricts->contains($district));

      // Another method to test
      $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $city->cityDistricts);
    }

    /** @test */
    public function a_city_has_many_metros()
    {
        $city = create('App\Models\City');

        $metro = create('App\Models\Metro', ['city_id' => $city->id]);

        $this->assertTrue($city->metros->contains($metro));

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $city->metros);
    }
}
