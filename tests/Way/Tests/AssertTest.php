<?php

class AssertTest extends PHPUnit_Framework_TestCase {

  protected $class = 'Way\Tests\Assert';

  // public function setUp() {}
  // public function tearDown() {}

  public function testShouldRespondToHave() {
    $this->doMethodCheck('has');
  }

  public function testShouldRespondToEq() {
    $this->doMethodCheck('eq');
  }

  public function testShouldRespondToBeValid() {
    $this->doMethodCheck('isValid');
  }

  public function testShouldRespondToBeNotValid() {
    $this->doMethodCheck('isNotValid');
  }

  public function testShouldRespondToBelongsToMany() {
    $this->doMethodCheck('belongsToMany');
  }

  public function testShouldRespondToBelongsTo() {
    $this->doMethodCheck('belongsTo');
  }

  public function testShouldRespondToHaveMany() {
    $this->doMethodCheck('haveMany');
  }

  public function testShouldRespondToHaveOne() {
    $this->doMethodCheck('haveOne');
  }

  public function testShouldRespondToMorphMany() {
    $this->doMethodCheck('morphMany');
  }

  public function testShouldRespondToMorphTo() {
    $this->doMethodCheck('morphTo');
  }

  public function testShouldRespondToRespondTo() {
    $this->doMethodCheck('respondsTo');
  }

  public function testShouldRespondToHaveRecursiveRelationship() {
    $this->doMethodCheck('haveRecursiveRelationship');
  }

  public function testShouldRespondToHaveRelationship() {
    $this->doMethodCheck('haveRelationship');
  }

  public function testShouldRespondToBeBoolean() {
    $this->doMethodCheck('isBoolean');
  }

  # privates 
  /**
   * Check fo alias, not for real method execution, cause to really use them
   * you have to include the relative trait
   */
  private function doMethodCheck($method) {
    $msg = "Expected the '$this->class' class to have method, '$method'.";

    $instance = Way\Tests\Assert::getInstance();

    $this->assertTrue($instance->isAnAlias($method), $msg);
  }
}
