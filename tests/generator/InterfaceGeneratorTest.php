<?php
namespace gossi\codegen\tests\generator;

use gossi\codegen\generator\ModelGenerator;
use gossi\codegen\model\PhpInterface;

/**
 * @group generator
 */
class InterfaceGeneratorTest extends \PHPUnit_Framework_TestCase {

	public function testSignature() {
		$expected = 'interface MyInterface {' . "\n" . '}';

		$interface = PhpInterface::create('MyInterface');
		$generator = new ModelGenerator();
		$code = $generator->generate($interface);
		
		$this->assertEquals($expected, $code);
	}
	
	public function testExtends() {
		$generator = new ModelGenerator();
		
		$expected = 'interface MyInterface extends \Iterator {' . "\n" . '}';
		$interface = PhpInterface::create('MyInterface')->addInterface('\Iterator');
		$this->assertEquals($expected, $generator->generate($interface));
		
		$expected = 'interface MyInterface extends \Iterator, \ArrayAccess {' . "\n" . '}';
		$interface = PhpInterface::create('MyInterface')->addInterface('\Iterator')->addInterface('\ArrayAccess');
		$this->assertEquals($expected, $generator->generate($interface));
	}
}
