<?php

namespace Tests\Unit\RepositoryTests;

use App\Models\Country;
use App\Repositories\CountryRepository;
use Tests\Unit\RepositoryTests\RepositoryTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CountryRepositoryTest extends RepositoryTestCase
{
    use RefreshDatabase;

    /** @test */
    public function country_model()
    {
      $this->assertEquals(app(CountryRepository::class)->model(), get_class(new Country));
    }

    /** @test */
    public function country_filters()
    {
      $this->employerLogin();

      $data = $this->fetchData('GET', '/api/crm/country');

      $this->assertEquals(app(CountryRepository::class)->getFieldsSearchable(), $data['data']['filters']);
    }
}
