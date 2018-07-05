<?php

namespace Tests\Unit\RepositoryTests;

use App\Models\CityDistrict;
use App\Repositories\CityDistrictRepository;
use Tests\Unit\RepositoryTests\RepositoryTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CityDistrictRepositoryTest extends RepositoryTestCase
{
    use RefreshDatabase;

    /** @test */
    public function district_model()
    {
      $this->assertEquals(app(CityDistrictRepository::class)->model(), get_class(new CityDistrict));
    }

    /** @test */
    public function district_filters()
    {
      $this->employerLogin();

      $data = $this->fetchData('GET', '/api/crm/district');

      $this->assertEquals(app(CityDistrictRepository::class)->getFieldsSearchable(), $data['data']['filters']);
    }
}
