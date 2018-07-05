<?php

namespace Tests\Unit\ModelTests;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MetroTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_metro_belongs_to_city()
    {
        $city = create('App\Models\City');
        $metro = create('App\Models\Metro', ['city_id' => $city->id]);

        $this->assertInstanceOf('App\Models\City', $metro->city);
    }
}
