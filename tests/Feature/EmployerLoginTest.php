<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmployerLoginTest extends TestCase
{
    use RefreshDatabase;

    protected $employer;

    public function setUp()
    {
      parent::setUp();

      $this->employer = create('App\Models\Employer');
    }

    /** @test */
    public function an_unexisting_user_may_not_login_through_crm_login_api()
    {
      $this->withExceptionHandling();

      $this->json('POST', '/api/crm/auth/login', [
        'phone' => '123',
        'password' => 'secret'
      ])->assertStatus(422);
    }

    /** @test */
    public function an_existing_employer_can_log_in_through_crm_login_api()
    {
      $request = $this->loginThroughAPI($this->employer->phone, 'secret');

      $data = json_decode($request->send()->getContent(true), true);

      $this->assertEquals('success', $data['result']);
    }

    /** @test */
    public function an_authenticated_employer_can_logout()
    {
      $response = $this->loginThroughAPI($this->employer->phone, 'secret')->assertStatus(200);

      $this->json('POST', '/api/crm/auth/logout')
           ->assertStatus(200);
    }

    protected function loginThroughAPI($phone, $password)
    {
      return $this->json('POST', '/api/crm/auth/login', [
        'phone' => $phone,
        'password' => $password
      ]);
    }
}
