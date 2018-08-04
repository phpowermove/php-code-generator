<?php
namespace gossi\codegen\tests\parser;

use gossi\codegen\model\PhpClass;
use gossi\codegen\tests\Fixtures;
use gossi\codegen\tests\parts\ModelAssertions;
use gossi\codegen\tests\parts\ValueTests;

/**
 * @group parser
 */
class ClassParserTest extends \PHPUnit_Framework_TestCase {

	use ModelAssertions;
	use ValueTests;

	public function setUp() {
		// they are not explicitely instantiated through new WhatEver(); and such not
		// required through composer's autoload
		require_once __DIR__ . '/../fixtures/Entity.php';
		require_once __DIR__ . '/../fixtures/ClassWithTraits.php';
		require_once __DIR__ . '/../fixtures/ClassWithConstants.php';
		require_once __DIR__ . '/../fixtures/ClassWithComments.php';
		require_once __DIR__ . '/../fixtures/ClassWithValues.php';
	}

	public function testEntity() {
		$class = PhpClass::fromFile(__DIR__ . '/../fixtures/Entity.php');

		$this->assertEquals(Fixtures::createEntity(), $class);
	}

	public function testMethodBody() {
		$class = PhpClass::fromFile(__DIR__ . '/../fixtures/HelloWorld.php');

		$this->assertTrue($class->hasMethod('sayHello'));

		$sayHello = $class->getMethod('sayHello');
		$this->assertEquals('return \'Hello World!\';', $sayHello->getBody());
	}

	public function testClassWithConstants() {
		$class = PhpClass::fromFile(__DIR__ . '/../fixtures/ClassWithConstants.php');

		$this->assertTrue($class->hasConstant('FOO'));
		$this->assertEquals('bar', $class->getConstant('FOO')->getValue());

		$this->assertTrue($class->hasConstant('NMBR'));
		$this->assertEquals(300, $class->getConstant('NMBR')->getValue());

		$this->assertTrue($class->hasConstant('BAR'));
		$this->assertEquals('self::FOO', $class->getConstant('BAR')->getExpression());
	}

	public function testClassWithTraits() {
		$class = PhpClass::fromFile(__DIR__ . '/../fixtures/ClassWithTraits.php');

		$this->assertTrue($class->hasTrait('DT'));
	}

	public function testClassWithComments() {
		$class = PhpClass::fromFile(__DIR__ . '/../fixtures/ClassWithComments.php');
		$this->assertClassWithComments($class);
	}

	public function testClassWithValues() {
		$class = PhpClass::fromFile(__DIR__ . '/../fixtures/ClassWithValues.php');
		$this->assertClassWithValues($class);
	}

	public function testTypeClass() {
		$class = PhpClass::fromFile(__DIR__ . '/../fixtures/TypeClass.php');

		$doSomething = $class->getMethod('doSomething');
		$options = $doSomething->getParameter('options');
		$this->assertEquals('Symfony\Component\OptionsResolver\OptionsResolver', $options->getType());
	}

	public function testMyCollection() {
		$class = PhpClass::fromFile(__DIR__ . '/../fixtures/MyCollection.php');

		$this->assertEquals('phootwork\collection\AbstractCollection', $class->getParentClassName());
		$this->assertTrue($class->hasInterface('phootwork\collection\Collection'));
	}

	public function testMyCollection2() {
		$class = PhpClass::fromFile(__DIR__ . '/../fixtures/MyCollection2.php');

		$this->assertEquals('\phootwork\collection\AbstractCollection', $class->getParentClassName());
		$this->assertTrue($class->hasInterface('\phootwork\collection\Collection'));
	}

}
