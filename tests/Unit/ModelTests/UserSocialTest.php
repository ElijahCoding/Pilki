<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserSocialTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_provider_belongs_to_a_user()
    {
      $user_social = create('App\Models\UserSocial');

      $this->assertInstanceOf('App\Models\User', $user_social->user);
    }
}
