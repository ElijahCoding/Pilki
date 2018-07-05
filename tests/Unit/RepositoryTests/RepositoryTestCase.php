<?php

namespace Tests\Unit\RepositoryTests;

use Tests\TestCase;

abstract class RepositoryTestCase extends TestCase
{
  public function fetchData(String $method, String $endpoint)
  {
    return json_decode($this->json($method, $endpoint)->send()->getContent(true), true);
  }
}
