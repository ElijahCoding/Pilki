<?php

namespace Tests\Feature\ViewTests;

use Tests\ViewTests\ViewTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewAuditTest extends ViewTestCase
{
    use RefreshDatabase;

    protected $audit;

    public function setUp()
    {
      parent::setUp();

      $this->audit = create('App\Models\Audit');
    }

    /** @test */
    public function an_unauthenticated_user_may_not_view_audits_in_json_format()
    {
      $this->withExceptionHandling();

      $this->json('GET', '/api/crm/audits')
           ->assertStatus(401);
    }
}
