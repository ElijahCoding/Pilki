<?php

namespace Tests\Feature\ViewTests;

use Tests\ViewTests\ViewTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewEmployerServicesTest extends ViewTestCase
{
    use RefreshDatabase;

    protected $employer;

    protected $service;

    protected $serviceCategory;

    public function setUp()
    {
      parent::setUp();

      $this->employer = create('App\Models\Employer');

      $this->service = create('App\Models\Service');

      $this->serviceCategory = create('App\Models\ServiceCategory');
    }

    /** @test */
    public function an_unauthenticated_user_may_not_view_employer_services_and_service_categories()
    {
      $this->withExceptionHandling();

      $this->json('GET', "/api/crm/employers/{$this->employer->id}/services")
           ->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_can_view_employer_services_in_json_format()
    {
      $this->employerLogin();

      // $this->employer->services()->attach($this->service, ['enabled' => true]);

      $this->employer->services()->syncWithoutDetaching([
          $this->service->id => ['enabled' => true]
      ]);

      // $this->employer->serviceCategories()->attach($this->serviceCategory, ['enabled' => true]);

      $this->employer->serviceCategories()->syncWithoutDetaching([
          $this->serviceCategory->id => ['enabled' => true]
      ]);

      $data = $this->fetchData('GET', "/api/crm/employers/{$this->employer->id}/services");

      $this->assertEquals('success', $data['result']);

      $this->assertEquals($data['data']['services'][0], $this->service->toArray());
      $this->assertEquals($data['data']['service_categories'][0], $this->serviceCategory->toArray());

      $this->assertDatabaseHas('employer_rel_services', [
          'employer_id' => $this->employer->id,
          'enabled' => true,
          'service_id' => $this->service->id,
          'service_type' => get_class($this->service)
      ]);

      $this->assertDatabaseHas('employer_rel_services', [
          'employer_id' => $this->employer->id,
          'enabled' => true,
          'service_id' => $this->serviceCategory->id,
          'service_type' => get_class($this->serviceCategory)
      ]);
    }
}
