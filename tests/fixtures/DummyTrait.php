<?php
namespace gossi\codegen\tests\fixtures;

/**
 * Dummy docblock
 */
trait DummyTrait {
	
	use VeryDummyTrait;
	
	private $iAmHidden;
	
	public function foo() {
		
	}
}