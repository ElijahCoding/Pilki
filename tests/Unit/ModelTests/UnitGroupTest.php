<?php

namespace Tests\Unit\ModelTests;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UnitGroupTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_unit_group_belongs_to_many_unit()
    {
      $unit = create('App\Models\Unit');

      $unitGroup = create('App\Models\UnitGroup');

      $unitGroup->units()->attach($unit);

      $this->assertDatabaseHas('unit_rel_unit_groups', ['unit_id' => $unit->id, 'unit_group_id' => $unitGroup->id]);
    }
}
