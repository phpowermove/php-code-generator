<?php
namespace gossi\codegen\tests\model;

use gossi\codegen\model\PhpInterface;
use gossi\codegen\generator\CodeGenerator;

class PhpInterfaceTest extends \PHPUnit_Framework_TestCase {

	
	public function testSignature() {
		$expected = 'interface MyInterface {
}';
		
		$trait = PhpInterface::create('MyInterface');
		
		$codegen = new CodeGenerator();
		$codegen->setGenerateDocblock(false);
		$code = $codegen->generateCode($trait);
		
		$this->assertEquals($expected, $code);
	}
}
