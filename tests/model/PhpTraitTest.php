<?php
namespace gossi\codegen\tests\model;

use gossi\codegen\model\PhpTrait;
use gossi\codegen\generator\CodeGenerator;

class PhpTraitTest extends \PHPUnit_Framework_TestCase {

	public function testSignature() {
		$expected = 'trait MyTrait {
}';
		
		$trait = PhpTrait::create('MyTrait');
		
		$codegen = new CodeGenerator();
		$codegen->setGenerateDocblock(false);
		$code = $codegen->generateCode($trait);
		
		$this->assertEquals($expected, $code);
	}
}
