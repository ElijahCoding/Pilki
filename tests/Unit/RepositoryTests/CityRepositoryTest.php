<?php

namespace Tests\Unit\RepositoryTests;

use App\Models\City;
use App\Repositories\CityRepository;
use Tests\Unit\RepositoryTests\RepositoryTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CityRepositoryTest extends RepositoryTestCase
{
  use RefreshDatabase;

  /** @test */
  public function city_model()
  {
    $this->assertEquals(app(CityRepository::class)->model(), get_class(new City));
  }

  /** @test */
  public function city_filters()
  {
    $this->employerLogin();

    $data = $this->fetchData('GET', '/api/crm/city');

    $this->assertEquals(app(CityRepository::class)->getFieldsSearchable(), $data['data']['filters']);
  }
}
