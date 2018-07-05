<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmployerTest extends TestCase
{
    use RefreshDatabase;

    protected $employer;

    public function setUp()
    {
      parent::setUp();

      $this->employer = create('App\Models\Employer');
    }

    /** @test */
    public function an_employer_belongs_to_a_unit()
    {
      $unit = create('App\Models\Unit');

      $employer = create('App\Models\Employer', ['unit_id' => $unit->id]);

      $this->assertInstanceOf('App\Models\Unit', $employer->unit);
    }

    /** @test */
    public function an_employer_belongs_to_a_legal_entity()
    {
      $legalEntity = create('App\Models\LegalEntity');

      $employer = create('App\Models\Employer', ['legal_entity_id' => $legalEntity->id]);

      $this->assertInstanceOf('App\Models\LegalEntity', $employer->legalEntity);
    }

    /** @test */
    public function an_employer_has_many_schedules()
    {
      $employer = create('App\Models\Employer');

      $employerSchedule = create('App\Models\EmployerSchedule', ['employer_id' => $employer->id]);

      $this->assertTrue($employer->schedules->contains($employerSchedule));
    }

    /** @test */
    public function an_employer_has_a_jwt_identifier()
    {
      $this->assertEquals($this->employer->id, $this->employer->getJWTIdentifier());
    }

    /** @test */
    public function an_employer_custom_claim_is_empty()
    {
      $this->assertEquals([], $this->employer->getJWTCustomClaims());
    }

    /** @test */
    public function an_employer_has_many_permissions()
    {
      $permission = create('App\Models\EmployerRelPermission', ['employer_id' => $this->employer->id]);

      $this->assertTrue($this->employer->permissions->contains($permission));
      $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->employer->permissions);
    }

    /** @test */
    public function an_employer_belongs_to_a_work_position()
    {
      $workPosition = create('App\Models\WorkPosition');

      $employer = create('App\Models\Employer', ['work_position_id' => $workPosition->id]);

      $this->assertInstanceOf('App\Models\WorkPosition', $employer->workPosition);
    }

    /** @test */
    public function an_employer_morphed_by_many_services()
    {
        $service = create('App\Models\Service');

        $this->employer->services()->syncWithoutDetaching([
            $service->id => ['enabled' => true]
        ]);

        $this->assertTrue($this->employer->services->contains($service));

        $this->assertDatabaseHas('employer_rel_services', [
            'employer_id' => $this->employer->id,
            'service_id' => $service->id,
            'service_type' => get_class($service),
            'enabled' => true
        ]);
    }

    /** @test */
    public function an_employer_morphed_by_many_service_categories()
    {
        $serviceCategory = create('App\Models\ServiceCategory');

        $this->employer->serviceCategories()->syncWithoutDetaching([
            $serviceCategory->id => ['enabled' => true]
        ]);

        $this->assertTrue($this->employer->serviceCategories->contains($serviceCategory));

        $this->assertDatabaseHas('employer_rel_services', [
            'employer_id' => $this->employer->id,
            'service_id' => $serviceCategory->id,
            'service_type' => get_class($serviceCategory),
            'enabled' => true
        ]);
    }
}
