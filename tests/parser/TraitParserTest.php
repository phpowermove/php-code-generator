<?php
namespace gossi\codegen\tests\parser;

use gossi\codegen\model\PhpTrait;
use gossi\codegen\tests\Fixtures;

/**
 * @group parser
 */
class TraitParserTest extends \PHPUnit_Framework_TestCase {

	public function setUp() {
		// they are not explicitely instantiated through new WhatEver(); and such not
		// required through composer's autoload
		require_once __DIR__ . '/../fixtures/DummyTrait.php';
	}

	public function testFromReflection() {
		$expected = Fixtures::createDummyTrait();
		$actual = PhpTrait::fromReflection(new \ReflectionClass('gossi\\codegen\\tests\\fixtures\\DummyTrait'));
		$this->assertEquals($expected, $actual);
	}

	public function testFromFile() {
		$expected = Fixtures::createDummyTrait();
		$actual = PhpTrait::fromFile(__DIR__ . '/../fixtures/DummyTrait.php');
		$this->assertEquals($expected, $actual);
	}

}
