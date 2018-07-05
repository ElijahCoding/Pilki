<?php

namespace Tests\Unit\ModelTests;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WorkPositionTest extends TestCase
{
    use RefreshDatabase;

    protected $workPosition;

    public function setUp()
    {
      parent::setUp();
      $this->workPosition = create('App\Models\WorkPosition');
    }

    /** @test */
    public function a_work_position_has_many_work_position_permissions()
    {
      $workPositionPermission = create('App\Models\WorkPositionRelPermission', ['work_position_id' => $this->workPosition->id]);

      $this->assertTrue($this->workPosition->permissions->contains($workPositionPermission));
    }
}
