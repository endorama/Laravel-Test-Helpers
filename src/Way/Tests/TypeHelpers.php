<?php namespace Way\Tests;

trait TypeHelpers {

  public function assertBoolean($actual, $message = null) {
    $message = $message ?: "Expected '$actual' to be a boolean.";
    $this->assertInternalType('bool', $actual, $message);
  }

}
