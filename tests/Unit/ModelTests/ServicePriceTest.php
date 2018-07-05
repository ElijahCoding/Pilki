<?php

namespace Tests\Unit\ModelTests;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ServicePriceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_service_price_belongs_to_a_service()
    {
      $service = create('App\Models\Service');

      $servicePrice = create('App\Models\ServicePrice', ['service_id' => $service->id]);

      $this->assertInstanceOf('App\Models\Service', $servicePrice->service);
    }
}
