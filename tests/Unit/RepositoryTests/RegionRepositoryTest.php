<?php

namespace Tests\Unit\RepositoryTests;

use App\Models\Region;
use App\Repositories\RegionRepository;
use Tests\Unit\RepositoryTests\RepositoryTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegionRepositoryTest extends RepositoryTestCase
{
    use RefreshDatabase;

    /** @test */
    public function region_model()
    {
      $this->assertEquals(app(RegionRepository::class)->model(), get_class(new Region));
    }

    /** @test */
    public function region_filters()
    {
      $this->employerLogin();

      $data = $this->fetchData('GET', '/api/crm/region');

      $this->assertEquals(app(RegionRepository::class)->getFieldsSearchable(), $data['data']['filters']);
    }
}
