<?php
namespace gossi\codegen\tests\fixture;

class ClassWithDefaultExpressions {

	private $bar = false;
	private $baz = true;
	private $number = 5;
	private $furz = 'bumbesje';

	public function foo($bar = null) {

	}
}