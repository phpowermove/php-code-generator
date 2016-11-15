<?php
namespace gossi\codegen\tests\parser;

use gossi\codegen\model\PhpClass;
use gossi\codegen\model\PhpParameter;
use gossi\codegen\tests\parts\ValueTests;

/**
 * @group parser
 */
class ParameterParserTest extends \PHPUnit_Framework_TestCase {
	
	use ValueTests;

	public function setUp() {
		// they are not explicitely instantiated through new WhatEver(); and such not
		// required through composer's autoload
		require_once __DIR__ . '/../fixtures/Entity.php';
		require_once __DIR__ . '/../fixtures/ValueClass.php';
	}

	public function testFromReflection() {
		$class = new \ReflectionClass('gossi\codegen\tests\fixtures\Entity');
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
		$this->assertEmpty($param->getValue());
		$this->assertEmpty($param->getType());
	}

	private function paramB(\ReflectionParameter $param) {
		$param = PhpParameter::fromReflection($param);

		$this->assertEquals('b', $param->getName());
		$this->assertTrue($param->isPassedByReference());
		$this->assertEmpty($param->getValue());
		$this->assertEquals('array', $param->getType());
	}

	private function paramC(\ReflectionParameter $param) {
		$param = PhpParameter::fromReflection($param);

		$this->assertEquals('c', $param->getName());
		$this->assertFalse($param->isPassedByReference());
		$this->assertEmpty($param->getValue());
		$this->assertEquals('\stdClass', $param->getType());
	}

	private function paramD(\ReflectionParameter $param) {
		$param = PhpParameter::fromReflection($param);

		$this->assertEquals('d', $param->getName());
		$this->assertFalse($param->isPassedByReference());
		$this->assertEquals('foo', $param->getValue());
		$this->assertEquals('string', $param->getType());
	}

	private function paramE(\ReflectionParameter $param) {
		$param = PhpParameter::fromReflection($param);

		$this->assertEquals('e', $param->getName());
		$this->assertFalse($param->isPassedByReference());
		$this->assertEmpty($param->getValue());
		$this->assertEquals('callable', $param->getType());
	}
	
	public function testValuesFromFile() {
		$class = PhpClass::fromFile(__DIR__ . '/../fixtures/ValueClass.php');
		$this->assertValueClass($class);
	}
	
	public function testValuesFromReflection() {
		$class = PhpClass::fromReflection(new \ReflectionClass('gossi\codegen\tests\fixtures\ValueClass'));
		$this->assertValueClass($class);
	}
	
	protected function assertValueClass(PhpClass $class) {
		$values = $class->getMethod('values');
		$this->isValueString($values->getParameter('paramString'));
		$this->isValueInteger($values->getParameter('paramInteger'));
		$this->isValueFloat($values->getParameter('paramFloat'));
		$this->isValueBool($values->getParameter('paramBool'));
		$this->isValueNull($values->getParameter('paramNull'));
	}
}
