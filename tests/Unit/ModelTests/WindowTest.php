<?php

namespace Tests\Unit\ModelTests;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WindowTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_window_belongs_to_a_unit()
    {
      $unit = create('App\Models\Unit');

      $window = create('App\Models\Window', ['unit_id' => $unit->id]);

      $this->assertInstanceOf('App\Models\Unit', $window->unit);
    }

    /** @test */
    public function a_window_belongs_to_an_employer()
    {
      $employer = create('App\Models\Employer');

      $window = create('App\Models\Window', ['employer_id' => $employer->id]);

      $this->assertInstanceOf('App\Models\Employer', $window->employer);
    }

    /** @test */
    public function a_window_belongs_to_an_equipment()
    {
      $equipment = create('App\Models\Equipment');

      $window = create('App\Models\Window', ['equipment_id' => $equipment->id]);

      $this->assertInstanceOf('App\Models\Equipment', $window->equipment);
    }
}
