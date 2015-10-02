<?php

namespace gossi\codegen\tests\fixture;

use gossi\codegen\tests\fixture\VeryDummyTrait;

/**
 * Dummy docblock
 */
trait DummyTrait
{
    use VeryDummyTrait;
    
    private $iAmHidden;
    
    public function foo()
    {
    }
}
