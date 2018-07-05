<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ServiceCategoryTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function a_service_category_has_many_services()
    {
      $serviceCategory = create('App\Models\ServiceCategory');

      $service = create('App\Models\Service', ['service_category_id' => $serviceCategory->id]);

      $this->assertTrue($serviceCategory->services->contains($service));
    }

    /** @test */
    public function service_category_access_unit_id_is_null_by_default()
    {
      $serviceCategory = create('App\Models\ServiceCategory');

      $this->assertEquals(null, $serviceCategory::ACCESS_UNIT_ID);
    }
}
