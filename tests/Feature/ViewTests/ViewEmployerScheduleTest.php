<?php

namespace Tests\Feature\ViewTests;

use Tests\ViewTests\ViewTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewEmployerScheduleTest extends ViewTestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_unauthenticated_employer_may_not_view_any_employer_shedules()
    {
        $this->withExceptionHandling();

        $employer = create('App\Models\Employer');

        $this->json('GET', "api/crm/employers/{$employer->id}/schedule")
             ->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_employer_view_employer_schedules_that_associated_with_employer()
    {
        $employer = $this->employerLogin();

        $employerSchedule = create('App\Models\EmployerSchedule', ['employer_id' => $employer->id]);

        $data = $this->fetchData('GET', "api/crm/employers/{$employer->id}/schedule");

        $this->assertEquals('success', $data['result']);
    }
}
