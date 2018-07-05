<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    public function setUp()
    {
      parent::setUp();
      $this->user = create('App\Models\User');
    }

    /** @test */
    public function a_user_has_many_social_providers()
    {
      $user_social = create('App\Models\UserSocial', ['user_id' => $this->user->id]);

      $this->assertTrue($this->user->userSocial->contains($user_social));
    }

    /** @test */
    public function user_remember_token_is_empty()
    {
      $this->assertEquals(null, $this->user->getRememberTokenName());
    }

    /** @test */
    public function a_user_has_a_jwt_identifier()
    {
      $this->assertEquals($this->user->id, $this->user->getJWTIdentifier());
    }

    /** @test */
    public function user_JWT_claim_is_empty()
    {
      $this->assertEquals([], $this->user->getJWTCustomClaims());
    }

    /** @test */
    public function a_user_is_morphed_to_many_images()
    {
      $image = create('App\Models\Image', [
        'imageable_type' => get_class($this->user),
        'imageable_id' => $this->user->id,
      ]);

      $this->user->images($image);

      $this->assertDatabaseHas('images', ['imageable_type' => get_class($this->user), 'imageable_id' => $this->user->id]);
    }
}
