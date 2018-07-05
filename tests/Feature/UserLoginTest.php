<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserLoginTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    public function setUp()
    {
      parent::setUp();

      $this->user = create('App\Models\User', ['password' => bcrypt('secret')]);
    }

    /** @test */
    public function an_unexisting_user_may_not_login_through_auth_login_api()
    {
      $this->withExceptionHandling();

      $this->json('POST', '/api/users/auth/login', [
        'phone' => '5544',
        'password' => 'secret'
      ])->assertStatus(500);
    }

    /** @test */
    public function an_exist_user_can_login_through_auth_login_api()
    {
      $request = $this->userLogin($this->user->phone, 'secret');

      $data = json_decode($request->send()->getContent(true), true);

      $this->assertEquals('success', $data['result']);

    }

    /** @test */
    public function an_authenticated_user_can_logout()
    {
      $response = $this->userLogin($this->user->phone, 'secret');

      $this->json('POST', '/api/users/auth/logout')
           ->assertStatus(200);
    }
}
