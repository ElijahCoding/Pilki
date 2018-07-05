<?php

namespace Tests\Unit\ModelTests;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmployerWindowTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_employer_window_belongs_to_an_employer()
    {
      $employer = create('App\Models\Employer');

      $employerWindow = create('App\Models\EmployerWindow', ['employer_id' => $employer->id]);

      $this->assertInstanceOf('App\Models\Employer', $employerWindow->employer);
    }

    /** @test */
    public function an_employer_window_belongs_to_a_service_category()
    {
      $serviceCategory = create('App\Models\ServiceCategory');

      $employerWindow = create('App\Models\EmployerWindow', ['service_category_id' => $serviceCategory->id]);

      $this->assertInstanceOf('App\Models\ServiceCategory', $employerWindow->serviceCategory);
    }
}
