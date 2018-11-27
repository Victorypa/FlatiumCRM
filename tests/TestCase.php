<?php

namespace Tests;

use App\Exceptions\Handler;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

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

    public function fetchData(String $method, String $endpoint)
    {
      return json_decode($this->json($method, $endpoint)->send()->getContent(true), true);
    }

    protected function signIn($user = null)
    {
        $user = $user ?: create('App\User');

        $this->actingAs($user);

        return $this;
    }
}
