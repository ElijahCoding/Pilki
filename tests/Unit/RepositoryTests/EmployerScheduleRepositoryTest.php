<?php

namespace Tests\Unit\RepositoryTests;

use App\Models\EmployerSchedule;
use App\Repositories\EmployerScheduleRepository;
use Tests\Unit\RepositoryTests\RepositoryTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmployerScheduleRepositoryTest extends RepositoryTestCase
{
  use RefreshDatabase;

  /** @test */
  public function employer_schedule_model()
  {
    $this->assertEquals(app(EmployerScheduleRepository::class)->model(), get_class(new EmployerSchedule));
  }
}
