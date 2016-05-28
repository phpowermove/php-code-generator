<?php
namespace gossi\codegen\tests\model;

use gossi\codegen\generator\CodeGenerator;
use gossi\codegen\model\PhpInterface;
use gossi\codegen\model\PhpMethod;

class PhpInterfaceTest extends \PHPUnit_Framework_TestCase {

	public function setUp() {
		// they are not explicitely instantiated through new WhatEver(); and such not
		// required through composer's autoload
		require_once __DIR__ . '/../fixture/DummyInterface.php';
	}

	private function createDummyInterface() {
		$interface = PhpInterface::create('DummyInterface')
			->setNamespace('gossi\codegen\tests\fixture')
			->setDescription('Dummy docblock')
			->setMethod(PhpMethod::create('foo'));
		$interface->generateDocblock();

		return $interface;
	}

	public function testFromReflection() {
		$expected = $this->createDummyInterface();
		$actual = PhpInterface::fromReflection(new \ReflectionClass('gossi\codegen\tests\fixture\DummyInterface'));
		$this->assertEquals($expected, $actual);
	}

	public function testFromFile() {
		$expected = $this->createDummyInterface();
		$actual = PhpInterface::fromFile(__DIR__ . '/../fixture/DummyInterface.php');
		$this->assertEquals($expected, $actual);
	}

	public function testSignature() {
		$expected = 'interface MyInterface {' . "\n" . '}';

		$trait = PhpInterface::create('MyInterface');

		$codegen = new CodeGenerator(['generateDocblock' => false, 'generateEmptyDocblock' => false]);
		$code = $codegen->generate($trait);

		$this->assertEquals($expected, $code);
	}
}
