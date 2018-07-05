<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_service_belongs_to_a_service_category()
    {
      $serviceCategory = create('App\Models\ServiceCategory');

      $service = create('App\Models\Service', ['service_category_id' => $serviceCategory->id]);

      $this->assertInstanceOf('App\Models\ServiceCategory', $service->serviceCategory);
    }

    /** @test */
    public function a_service_access_unit_id_is_null_by_default()
    {
      $service = create('App\Models\Service');

      $this->assertEquals(null, $service->ACCESS_UNIT_ID);
    }

    /** @test */
    public function a_service_has_many_service_resources()
    {
      $service = create('App\Models\Service');

      $serviceResource = create('App\Models\ServiceResource', ['service_id' => $service->id]);

      $this->assertTrue($service->serviceResource->contains($serviceResource));
    }

    /** @test */
    public function a_service_has_many_service_prices()
    {
      $service = create('App\Models\Service');

      $servicePrice = create('App\Models\ServicePrice', ['service_id' => $service->id]);

      $this->assertTrue($service->servicePrice->contains($servicePrice));
    }
}
