<?php
namespace gossi\codegen\tests\model;

use gossi\codegen\generator\CodeGenerator;
use gossi\codegen\model\PhpMethod;
use gossi\codegen\model\PhpProperty;
use gossi\codegen\model\PhpTrait;

class PhpTraitTest extends \PHPUnit_Framework_TestCase {

	public function setUp() {
		// they are not explicitely instantiated through new WhatEver(); and such not
		// required through composer's autoload
		require_once __DIR__ . '/../fixture/DummyTrait.php';
	}

	/**
	 * @return PhpTrait
	 */
	private function createDummyTrait() {
		$trait = new PhpTrait('DummyTrait');
		$trait->setNamespace('gossi\\codegen\\tests\\fixture');
		$trait->setDescription('Dummy docblock');
		$trait->setMethod(PhpMethod::create('foo')->setVisibility('public'));
		$trait->setProperty(PhpProperty::create('iAmHidden')->setVisibility('private'));
		$trait->addUseStatement('gossi\\codegen\\tests\\fixture\\VeryDummyTrait');
		$trait->addTrait('VeryDummyTrait');
		$trait->generateDocblock();

		return $trait;
	}

	public function testFromReflection() {
		$expected = $this->createDummyTrait();
		$actual = PhpTrait::fromReflection(new \ReflectionClass('gossi\\codegen\\tests\\fixture\\DummyTrait'));
		$this->assertEquals($expected, $actual);
	}

	public function testFromFile() {
		$expected = $this->createDummyTrait();
		$actual = PhpTrait::fromFile(__DIR__ . '/../fixture/DummyTrait.php');
		$this->assertEquals($expected, $actual);
	}

	public function testSignature() {
		$expected = 'trait MyTrait {' . "\n" . '}';

		$trait = PhpTrait::create('MyTrait');

		$codegen = new CodeGenerator(['generateDocblock' => false, 'generateEmptyDocblock' => false]);
		$code = $codegen->generate($trait);

		$this->assertEquals($expected, $code);
	}

}
