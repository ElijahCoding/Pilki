<?php

namespace Tests\Unit\ValidationTests;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ServiceValidationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_service_requires_an_article()
    {
        $this->createService(['article' => null])
            ->assertStatus(422);
    }

    /** @test */
    public function a_service_requires_a_valid_service_category_id()
    {
        $this->createService(['service_category_id' => null])
            ->assertStatus(422);
    }

    /** @test */
    public function a_service_requires_a_title()
    {
        $this->createService(['title' => null])
            ->assertStatus(422);
    }

    /** @test */
    public function a_service_requires_a_title_online()
    {
        $this->createService(['title_online' => null])
            ->assertStatus(422);
    }

    /** @test */
    public function a_service_requires_a_title_cashier()
    {
        $this->createService(['title_cashier' => null])
            ->assertStatus(422);
    }

    protected function createService($overrides = [])
    {
        $this->withExceptionHandling()->superUserLogin();

        $service = make('App\Models\Service', $overrides);

        return $this->json('POST', 'api/crm/service', $service->toArray());
    }
}
