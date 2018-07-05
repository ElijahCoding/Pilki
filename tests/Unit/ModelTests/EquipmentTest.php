<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EquipmentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_equipment_has_many_equipment_windows()
    {
      $equipment = create('App\Models\Equipment');

      $equipmentWindow = create('App\Models\EquipmentWindow', ['equipment_id' => $equipment->id]);

      $this->assertTrue($equipment->equipmentWindows->contains($equipmentWindow));
    }
}
