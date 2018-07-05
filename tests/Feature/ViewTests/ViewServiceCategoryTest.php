<?php

namespace Tests\Feature;

use Tests\ViewTests\ViewTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewServiceCategoryTest extends ViewTestCase
{
  use RefreshDatabase;

  protected $serviceCategory;

  public function setUp()
  {
    parent::setUp();

    $this->serviceCategory = create('App\Models\ServiceCategory');
  }

  /** @test */
  public function an_unauthenticated_user_may_not_view_any_service_category()
  {
    $this->withExceptionHandling();

    $this->json('GET', '/api/crm/service/category')
         ->assertStatus(401);

    $this->json('GET', '/api/crm/service/category' . $this->serviceCategory->id)
        ->assertStatus(401);
  }

  /** @test */
  public function an_authenticated_user_can_view_service_categories_in_json_format()
  {
      $this->employerLogin();

      $data = $this->fetchData('GET', '/api/crm/service/category');

      $this->assertEquals($this->serviceCategory->title, $data['data']['items'][0]['title']);
  }

  /** @test */
  public function an_authenticated_user_can_view_a_single_service_category_in_json_format()
  {
      $this->employerLogin();

      $data = $this->fetchData('GET', '/api/crm/service/category/' . $this->serviceCategory->id);

      $this->assertEquals('success', $data['result']);

      $this->assertEquals($this->serviceCategory->toArray(), $data['data']);
  }
}
