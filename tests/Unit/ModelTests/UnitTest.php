<?php

namespace Tests\Unit\ModelTests;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UnitTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_unit_belongs_to_a_legal_entity()
    {
      $legalEntity = create('App\Models\LegalEntity');

      $unit = create('App\Models\Unit', ['legal_entity_id' => $legalEntity->id]);

      $this->assertInstanceOf('App\Models\LegalEntity', $unit->legalEntity);
    }

    /** @test */
    public function a_unit_belongs_to_many_unit_groups()
    {
      $unit = create('App\Models\Unit');

      $unitGroup = create('App\Models\UnitGroup');

      $unit->unitGroups()->attach($unitGroup);

      $this->assertDatabaseHas('unit_rel_unit_groups', ['unit_group_id' => $unitGroup->id, 'unit_id' => $unit->id]);
    }
}
