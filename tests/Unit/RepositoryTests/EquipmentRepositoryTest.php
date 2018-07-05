<?php

namespace Tests\Unit\RepositoryTests;

use App\Models\Equipment;
use App\Repositories\EquipmentRepository;
use Tests\Unit\RepositoryTests\RepositoryTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EquipmentRepositoryTest extends RepositoryTestCase
{
  use RefreshDatabase;

  /** @test */
  public function equipment_model()
  {
    $this->assertEquals(app(EquipmentRepository::class)->model(), get_class(new Equipment));
  }
}
