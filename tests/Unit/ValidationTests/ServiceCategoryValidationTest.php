<?php

namespace Tests\Unit\ValidationTests;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ServiceCategoryValidationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_service_category_requires_a_title()
    {
      $this->withExceptionHandling()->superUserLogin();

      $serviceCategory = make('App\Models\ServiceCategory', ['title' => null]);

      $this->json('POST', 'api/crm/service/category', $serviceCategory->toArray())
           ->assertStatus(422);
    }
}
