<?php

namespace Tests;

use App\Exceptions\Handler;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp()
    {
        parent::setUp();

        $this->disableExceptionHandling();
    }

    protected function disableExceptionHandling()
    {
        $this->oldExceptionHandler = $this->app->make(ExceptionHandler::class);

        $this->app->instance(ExceptionHandler::class, new class extends Handler {
            public function __construct() {}
            public function report(\Exception $e) {}
            public function render($request, \Exception $e) {
                throw $e;
            }
        });
    }

    protected function withExceptionHandling()
    {
        $this->app->instance(ExceptionHandler::class, $this->oldExceptionHandler);

        return $this;
    }

    public function employerLogin($employer = null)
    {
      $employer = $employer ?: create('App\Models\Employer' ,['password' => bcrypt('secret')]);

      $this->json('POST', '/api/crm/auth/login', [
        'phone' => $employer->phone,
        'password' => 'secret'
      ]);

      return $employer;
    }

    public function userLogin($phone, $password)
    {
      return $this->json('POST', '/api/users/auth/login', [
        'phone' => $phone,
        'password' => $password
      ]);
    }

    protected function superUserLogin()
    {
      $employer = create('App\Models\Employer', ['password' => bcrypt('secret'), 'is_superuser' => true]);

      return $this->employerLogin($employer);
    }
}
