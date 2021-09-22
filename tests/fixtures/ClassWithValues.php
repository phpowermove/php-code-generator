<?php
namespace phpowermove\codegen\tests\fixtures;

class ClassWithValues {

	private $arr = ['papagei' => ['name' => 'Mr. Cottons Papagei']];
	private $bar = false;
	private $baz = true;
	private $furz = 'bumbesje';
	private $magic = __LINE__;
	private $null = null;
	private $number = 5;

	public function foo($bar = null, $baz = false) {
	}
}
