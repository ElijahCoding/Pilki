<?php

namespace Tests\Unit\ModelTests;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EquipmentWindowTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_equipment_window_belongs_to_an_equipment()
    {
      $equipment = create('App\Models\Equipment');

      $equipmentWindow = create('App\Models\EquipmentWindow', ['equipment_id' => $equipment->id]);

      $this->assertInstanceOf('App\Models\Equipment', $equipmentWindow->equipment);
    }
}
