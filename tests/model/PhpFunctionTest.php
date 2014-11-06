<?php
namespace gossi\codegen\tests\model;

use gossi\docblock\Docblock;
use gossi\codegen\model\PhpFunction;
use gossi\codegen\model\PhpParameter;

class PhpFunctionTest extends \PHPUnit_Framework_TestCase {

	public function setUp() {
		// they are not explicitely instantiated through new WhatEver(); and such not
		// required through composer's autoload
		require_once __DIR__ . '/../fixture/functions.php';
	}

	public function testFromReflection() {
		$doc = new Docblock('/**
 * Makes foo with bar
 * 
 * @param string $baz
 * @return string
 */');
		$function = new PhpFunction('wurst');
		$function->addParameter(PhpParameter::create('baz')
			->setDefaultValue(null))
			->setBody('return \'wurst\';')
			->setDocblock($doc)
			->setDescription($doc->getShortDescription())
			->setLongDescription($doc->getLongDescription());

		$this->assertEquals($function, PhpFunction::fromReflection(new \ReflectionFunction('wurst')));
	}
}