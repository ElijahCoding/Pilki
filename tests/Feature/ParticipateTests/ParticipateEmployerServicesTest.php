<?php

namespace Tests\Feature\ParticipateTests;

use Exception;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParticipateEmployerServicesTest extends TestCase
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
    public function an_employer_can_link_only_one_type_service()
    {
        $this->employerLogin($this->employer);

        try {
            $this->json('POST', "api/crm/employers/{$this->employer->id}/services",
            array_merge($this->service->toArray(), ['type' => 'service', 'enabled' => true]));

            $this->json('POST', "api/crm/employers/{$this->employer->id}/services",
            array_merge($this->service->toArray(), ['type' => 'service', 'enabled' => true]));
        } catch (Exception $e) {
            $this->fail('Did not expect to insert the same record set twice.');
        }

        $this->assertCount(1, $this->employer->services);
    }

    /** @test */
    public function an_employer_can_link_only_one_type_service_category()
    {
        $this->employerLogin($this->employer);

        try {
            $this->json('POST', "api/crm/employers/{$this->employer->id}/services",
            array_merge($this->service->toArray(), ['type' => 'category', 'enabled' => true]));

            $this->json('POST', "api/crm/employers/{$this->employer->id}/services",
            array_merge($this->service->toArray(), ['type' => 'category', 'enabled' => true]));
        } catch (Exception $e) {
            $this->fail('Did not expect to insert the same record set twice.');
        }

        $this->assertCount(1, $this->employer->serviceCategories);
    }

    /** @test */
    public function an_unauthenticated_employer_may_not_create_or_delete_an_employer_service_and_service_category()
    {
        $this->withExceptionHandling();

        $this->json('POST', "api/crm/employers/{$this->employer->id}/services",
        array_merge($this->service->toArray(), ['type' => 'category', 'enabled' => true]))
             ->assertStatus(401);

        $this->json('POST', "api/crm/employers/{$this->employer->id}/services",
        array_merge($this->service->toArray(), ['type' => 'service', 'enabled' => true]))
             ->assertStatus(401);

        $this->json('DELETE', "api/crm/employers/{$this->employer->id}/services/{$this->service->id}")
             ->assertStatus(401);

        $this->json('DELETE', "api/crm/employers/{$this->employer->id}/services/{$this->serviceCategory->id}")
                ->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_employer_can_create_an_employer_service()
    {
        $this->employerLogin($this->employer);

        $request = $this->json('POST', "api/crm/employers/{$this->employer->id}/services",
        array_merge($this->service->toArray(), ['type' => 'service', 'enabled' => true]));

        $this->assertDatabaseHas('employer_rel_services', [
            'employer_id' => $this->employer->id,
            'service_id' => $this->service->id,
            'service_type' => get_class($this->service),
            'enabled' => true
        ]);

        $this->assertEquals(json_decode($request->getContent())->result, 'success');
    }

    /** @test */
    public function an_authenticated_employer_can_create_an_employer_service_category()
    {
        $this->employerLogin($this->employer);

        $request = $this->json('POST', "api/crm/employers/{$this->employer->id}/services",
        array_merge($this->serviceCategory->toArray(), ['type' => 'category', 'enabled' => true]));

        $this->assertDatabaseHas('employer_rel_services', [
            'employer_id' => $this->employer->id,
            'service_id' => $this->serviceCategory->id,
            'service_type' => get_class($this->serviceCategory),
            'enabled' => true
        ]);

        $this->assertEquals(json_decode($request->getContent())->result, 'success');
    }

}
