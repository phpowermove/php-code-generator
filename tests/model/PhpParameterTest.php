<?php
namespace gossi\codegen\tests\model;

use gossi\codegen\model\PhpFunction;
use gossi\codegen\model\PhpParameter;

class PhpParameterTest extends \PHPUnit_Framework_TestCase {

	public function setUp() {
		// they are not explicitely instantiated through new WhatEver(); and such not
		// required through composer's autoload
		require_once __DIR__ . '/../fixture/Entity.php';
	}

	public function testFromReflection() {
		$class = new \ReflectionClass('gossi\codegen\tests\fixture\Entity');
		$ctor = $class->getMethod('__construct');
		$params = $ctor->getParameters();
		
		foreach ($params as $param) {
			switch ($param->getName()) {
				case 'a':
					$this->paramA($param);
					break;
				case 'b':
					$this->paramB($param);
					break;
				case 'c':
					$this->paramC($param);
					break;
				case 'd':
					$this->paramD($param);
					break;
				case 'e':
					$this->paramE($param);
					break;
			}
		}
	}

	private function paramA(\ReflectionParameter $param) {
		$param = PhpParameter::fromReflection($param);
		
		$this->assertEquals('a', $param->getName());
		$this->assertFalse($param->isPassedByReference());
		$this->assertEmpty($param->getDefaultValue());
		$this->assertEmpty($param->getType());
	}

	private function paramB(\ReflectionParameter $param) {
		$param = PhpParameter::fromReflection($param);
		
		$this->assertEquals('b', $param->getName());
		$this->assertTrue($param->isPassedByReference());
		$this->assertEmpty($param->getDefaultValue());
		$this->assertEquals('array', $param->getType());
	}

	private function paramC(\ReflectionParameter $param) {
		$param = PhpParameter::fromReflection($param);
		
		$this->assertEquals('c', $param->getName());
		$this->assertFalse($param->isPassedByReference());
		$this->assertEmpty($param->getDefaultValue());
		
		// PHP BUG ?: Doesn't return \stdClass, just stdClass
		// $this->assertEquals('\stdClass', $param->getType());
		$this->assertEquals('stdClass', $param->getType());
	}

	private function paramD(\ReflectionParameter $param) {
		$param = PhpParameter::fromReflection($param);
		
		$this->assertEquals('d', $param->getName());
		$this->assertFalse($param->isPassedByReference());
		$this->assertEquals('foo', $param->getDefaultValue());
		$this->assertEmpty($param->getType());
	}

	private function paramE(\ReflectionParameter $param) {
		$param = PhpParameter::fromReflection($param);
		
		$this->assertEquals('e', $param->getName());
		$this->assertFalse($param->isPassedByReference());
		$this->assertEmpty($param->getDefaultValue());
		$this->assertEquals('callable', $param->getType());
	}

	public function testType() {
		$param = new PhpParameter();
		
		$this->assertNull($param->getType());
		$this->assertSame($param, $param->setType('array'));
		$this->assertEquals('array', $param->getType());
		$this->assertSame($param, $param->setType('array', 'boo!'));
		$this->assertEquals('boo!', $param->getTypeDescription());
	}
	
	public function testSimpleParameter() {
		$function = new PhpFunction();
		$function->addSimpleParameter('param1', 'string');
		
		$this->assertTrue($function->hasParameter('param1'));
		$this->assertFalse($function->hasParameter('param2'));
		$param1 = $function->getParameter('param1');
		$this->assertEquals('string', $param1->getType());
		$this->assertFalse($param1->hasDefaultValue());
		
		$function->addSimpleParameter('param2', 'string', null);
		
		$this->assertTrue($function->hasParameter('param2'));
		$param2 = $function->getParameter('param2');
		$this->assertEquals('string', $param2->getType());
		$this->assertNull($param2->getDefaultValue());
	}
	
	public function testSimpleDescParameter() {
		$function = new PhpFunction();
		$function->addSimpleDescParameter('param1', 'string');

		$this->assertFalse($function->hasParameter('param2'));
		$param1 = $function->getParameter('param1');
		$this->assertEquals('string', $param1->getType());
		$this->assertFalse($param1->hasDefaultValue());
	
		$function->addSimpleDescParameter('param2', 'string', 'desc');
	
		$this->assertTrue($function->hasParameter('param2'));
		$param2 = $function->getParameter('param2');
		$this->assertEquals('string', $param2->getType());
		$this->assertFalse($param2->hasDefaultValue());
		
		$function->addSimpleDescParameter('param3', 'string', 'desc', null);
		
		$this->assertTrue($function->hasParameter('param3'));
		$param3 = $function->getParameter('param3');
		$this->assertEquals('string', $param3->getType());
		$this->assertNull($param3->getDefaultValue());
	}
	
}