<?php

namespace Tests\Unit\RepositoryTests;

use App\Models\Employer;
use App\Repositories\EmployerRepository;
use Tests\Unit\RepositoryTests\RepositoryTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmployerRepositoryTest extends RepositoryTestCase
{
  use RefreshDatabase;

  /** @test */
  public function employer_model()
  {
    $this->assertEquals(app(EmployerRepository::class)->model(), get_class(new Employer));
  }

  /** @test */
  public function employer_filters()
  {
    $this->employerLogin();

    $data = $this->fetchData('GET', '/api/crm/employers');

    $this->assertEquals(app(EmployerRepository::class)->getFieldsSearchable(), $data['data']['filters']);
  }
}
