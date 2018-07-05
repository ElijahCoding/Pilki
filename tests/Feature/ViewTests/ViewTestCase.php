<?php

namespace Tests\ViewTests;

use Tests\TestCase;

abstract class ViewTestCase extends TestCase
{
  public function fetchData(String $method, String $endpoint)
  {
    return json_decode($this->json($method, $endpoint)->send()->getContent(true), true);
  }

  public function fetchResult($request, $result)
  {
    $this->assertEquals($request->toArray(), $result);
  }
}
