<?php

namespace Tests;

use Mockery;

trait ModelHelpers
{
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

    public function assertHasOne($relationshipName, $class, $relatedModel = null, $foreignKey = null)
    {
        $this->assertRelationship('hasOne', $relationshipName, $class, $relatedModel, null, $foreignKey);
    }

    public function assertHasMany($relationshipName, $class, $relatedModel = null, $foreignKey = null)
    {
        $this->assertRelationship('hasMany', $relationshipName, $class, $relatedModel, null, $foreignKey);
    }

    public function assertBelongsToMany($relationshipName, $class, $relatedModel = null, $table = null, $foreignKey = null, $otherKey = null)
    {
        $this->assertRelationship('belongsToMany', $relationshipName, $class, $relatedModel, $table, $foreignKey, $otherKey);
    }

    public function assertBelongsTo($relationshipName, $class, $relatedModel = null, $foreignKey = null)
    {
        $this->assertRelationship('belongsTo', $relationshipName, $class, $relatedModel, null, $foreignKey);
    }

    public function assertRespondsTo($method, $class, $message = null)
    {
        $message = $message ?: "Expected the '$class' class to have method, '$method'.";

        $this->assertTrue(
            method_exists($class, $method),
            $message
        );
    }

    public function assertRelationship($type, $relationshipName, $class, $relatedModel = null, $table = null, $foreignKey = null, $otherKey = null)
    {
        $this->assertRespondsTo($relationshipName, $class);

        $stub = $this->getMockBuilder('Illuminate\Database\Query\Builder')
                     ->disableOriginalConstructor()
                     ->getMock();

        $stub->expects($this->any())
             ->method($this->anything())
             ->will($this->returnValue($stub));

        $mock = Mockery::mock($class."[$type]");
        $m = $mock->shouldReceive($type)->once()->andReturn($stub);

        if( is_null($relatedModel) ) {
           $m->with('/' . str_singular($relationshipName) . '/i');
        } else {
            $modelName = '/' . $relatedModel . '/i';

            if( is_null($table) ) { // hasOne or belongsTo or hasMany
                if( is_null($foreignKey) ) {
                    $m->with($modelName);
                } else {
                    $m->with($modelName, $foreignKey);
                }
            } else { // belongsToMany
                if( is_null($foreignKey) ) {
                    $m->with($modelName, $table);
                } else {
                    if( is_null($otherKey) ) {
                        $m->with($modelName, $table, $foreignKey);
                    } else {
                        $m->with($modelName, $table, $foreignKey, $otherKey);
                    }
                }
            }
        }

        $mock->$relationshipName();
    }
}
