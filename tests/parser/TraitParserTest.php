<?php
namespace phpowermove\codegen\tests\parser;

use phpowermove\codegen\model\PhpTrait;
use phpowermove\codegen\tests\Fixtures;
use PHPUnit\Framework\TestCase;

/**
 * @group parser
 */
class TraitParserTest extends TestCase {

	public function setUp() {
		// they are not explicitely instantiated through new WhatEver(); and such not
		// required through composer's autoload
		require_once __DIR__ . '/../fixtures/DummyTrait.php';
	}

	public function testFromFile() {
		$expected = Fixtures::createDummyTrait();
		$actual = PhpTrait::fromFile(__DIR__ . '/../fixtures/DummyTrait.php');
		$this->assertEquals($expected, $actual);
	}

}
