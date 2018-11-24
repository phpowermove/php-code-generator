<?php
namespace gossi\codegen\tests\utils;

use PHPUnit\Framework\TestCase;
use gossi\codegen\generator\utils\Writer;
use gossi\codegen\utils\ReflectionUtils;

class ReflectionUtilsTest extends TestCase {

	public function setUp() {
		// they are not explicitely instantiated through new WhatEver(); and such not
		// required through composer's autoload
		require_once __DIR__ . '/../fixtures/functions.php';
		require_once __DIR__ . '/../fixtures/OverridableReflectionTest.php';
	}

	public function testFunctionBody() {
		$actual = ReflectionUtils::getFunctionBody(new \ReflectionFunction('wurst'));
		$expected = 'return \'wurst\';';

		$this->assertEquals($expected, $actual);

		$actual = ReflectionUtils::getFunctionBody(new \ReflectionFunction('inline'));
		$expected = 'return \'x\';';

		$this->assertEquals($expected, $actual);
	}

	public function testGetOverridableMethods() {
		$ref = new \ReflectionClass('gossi\codegen\tests\fixtures\OverridableReflectionTest');
		$methods = ReflectionUtils::getOverrideableMethods($ref);

		$this->assertEquals(4, count($methods));

		$methods = array_map(function ($v) {
			return $v->name;
		}, $methods);
		sort($methods);
		$this->assertEquals([
			'a',
			'd',
			'e',
			'h'
		], $methods);
	}

	public function testGetUnindentedDocComment() {
		$writer = new Writer();
		$comment = $writer->writeln('/**')->indent()->writeln(' * Foo.')->write(' */')->getContent();

		$this->assertEquals("/**\n * Foo.\n */", ReflectionUtils::getUnindentedDocComment($comment));
	}
}
