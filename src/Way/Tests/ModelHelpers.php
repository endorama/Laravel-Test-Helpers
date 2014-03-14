<?php namespace Way\Tests;

use Mockery;

trait ModelHelpers {

    public function tearDown()
    {
        Mockery::close();
    }

    public function assertValid($model)
    {
        $this->assertRespondsTo('validate', $model, "The 'validate' method does not exist on this model.");
        $this->assertTrue($model->validate(), 'Model did not pass validation.');
    }

    public function assertNotValid($model)
    {
        $this->assertRespondsTo('validate', $model, "The 'validate' method does not exist on this model.");
        $this->assertFalse($model->validate(), 'Did not expect model to pass validation.');
    }

    public function assertBelongsToMany($parent, $child)
    {
        $this->assertRelationship($parent, $child, 'belongsToMany');
    }

    public function assertBelongsTo($parent, $child)
    {
        $this->assertRelationship($parent, $child, 'belongsTo');
    }

    public function assertHasMany($relation, $class)
    {
        $this->assertRelationship($relation, $class, 'hasMany');
    }

    public function assertHasOne($relation, $class)
    {
        $this->assertRelationship($relation, $class, 'hasOne');
    }

    public function assertMorphMany($relation, $class, $morphable)
    {
        $this->assertRelationship($relation, $class, 'morphMany');
    }

    public function assertMorphTo($relation, $class)
    {
        $this->assertRelationship($relation, $class, 'morphTo');
    }

    public function assertRespondsTo($method, $class, $message = null)
    {
        $message = $message ?: "Expected the '$class' class to have method, '$method'.";

        $this->assertTrue(
            method_exists($class, $method),
            $message
        );
    }

    public function assertRecursiveRelationship($relationship, $class, $type) {
      // check that class respond to relationship method
      $this->assertRespondsTo($relationship, $class);

      // calculate base class for recursive relationship
      $baseClass = explode('\\', $class);
      $baseClass = end($baseClass);

      // create mocked object
      $mocked = $this->createRelationshipMock($relationship, $class, $type, $baseClass);

      // run method to perform assertion
      $mocked->$relationship();
    }

    public function assertRelationship($relationship, $class, $type) {
      // check that class respond to relationship method
      $this->assertRespondsTo($relationship, $class);

      // create mocked object ( baseClass is the relationship )
      $mocked = $this->createRelationshipMock($relationship, $class, $type, $relationship);

      // run method to perform assertion
      $class->$relationship();
    }

    public function getArgumentsRelationship($relationship, $class, $type) {
        $mocked = Mockery::mock($class."[$type]")->shouldIgnoreMissing()->asUndefined();

        $args = array();
        
        $mocked->shouldReceive($type)
              ->once()
              ->andReturnUsing(function () use (&$args)
              {
                $args = func_get_args();
                return Mockery::self();
              });
        $mocked->$relationship();
        
        return $args;
    }

    /**
     * Add correct args to $type method in $class
     * 
     * @return Mockery::Mock the mocked object with correct functionality
     */
    private function createRelationshipMock($relationship, $class, $type, $baseClass) {
      // get arguments for relationship
      $args = $this->getArgumentsRelationship($relationship, $class, $type);
      
      // create base mocked object
      $mocked = Mockery::mock($class."[$type]")->shouldIgnoreMissing()->asUndefined();
      
      // set correct arguments on mock
      switch(count($args)) {
        case 1 :
          $mocked
            ->shouldReceive($type)
            ->once()
            ->with('/' . str_singular($baseClass) . '/i')
            ->andReturn(Mockery::self());
          break;
        case 2 :
          $mocked
            ->shouldReceive($type)
            ->once()
            ->with('/' . str_singular($baseClass) . '/i', $args[1])
            ->andReturn(Mockery::self());
          break;
        case 3 :
          $mocked
            ->shouldReceive($type)
            ->once()
            ->with('/' . str_singular($baseClass) . '/i', $args[1], $args[2])
            ->andReturn(Mockery::self());
          break;
        case 4 :
          $mocked
            ->shouldReceive($type)
            ->once()
            ->with('/' . str_singular($baseClass) . '/i', $args[1], $args[2], $args[3])
            ->andReturn(Mockery::self());
          break;
        default :
          $mocked
          ->shouldReceive($type)
          ->once()
          ->andReturn(Mockery::self());
          break;
      }

      return $mocked;
    }

}
