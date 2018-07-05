<?php

namespace Tests\Unit\ModelTests;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmployerScheduleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_employer_schedule_belongs_to_an_employer()
    {
      $employer = create('App\Models\Employer');

      $employerSchedule = create('App\Models\EmployerSchedule', ['employer_id' => $employer->id]);

      $this->assertInstanceOf('App\Models\Employer', $employerSchedule->employer);
    }

    /** @test */
    public function an_employer_schedule_belongs_to_an_equipment()
    {
      $equipment = create('App\Models\Equipment');

      $employerSchedule = create('App\Models\EmployerSchedule', ['equipment_id' => $equipment->id]);

      $this->assertInstanceOf('App\Models\Equipment', $employerSchedule->equipment);
    }
}
