<?php

namespace Tests\Feature\ParticipateTests;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParticipateEmployerScheduleTest extends TestCase
{
    use RefreshDatabase;

    protected $employerSchedule;

    public function setUp()
    {
      parent::setUp();

      $this->employerSchedule = create('App\Models\EmployerSchedule');
    }

    /** @test */
    public function an_unauthenticated_employer_may_not_create_or_delete_an_employer_schedule()
    {
        $this->withExceptionHandling();

        $employer = create('App\Models\Employer');

        $this->json('POST', "api/crm/employers/{$employer->id}/schedule" ,$this->employerSchedule->toArray())
             ->assertStatus(401);

        $this->json('DELETE', "api/crm/employers/{$employer->id}/schedule/{$this->employerSchedule->id}")
             ->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_employer_can_create_an_employer_schedule()
    {
        $employer = $this->employerLogin();

        $this->json('POST', "api/crm/employers/{$employer->id}/schedule", $this->employerSchedule->toArray());

        $this->assertDatabaseHas('employer_schedules', [
            'begin_at' => $this->employerSchedule->begin_at,
            'end_at' => $this->employerSchedule->end_at
        ]);
    }

}
