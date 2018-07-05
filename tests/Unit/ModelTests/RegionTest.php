<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_region_belongs_to_a_country()
    {
        $country = create('App\Models\Country');

        $region = create('App\Models\Region', ['country_id' => $country->id]);

        $this->assertInstanceOf('App\Models\Country', $region->country);
    }

    /** @test */
    public function a_region_has_many_cities()
    {
        $region = create('App\Models\Region');

        $city = create('App\Models\City', ['region_id' => $region->id]);

        $this->assertTrue($region->cities->contains($city));
    }
}
