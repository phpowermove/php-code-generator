<?php
namespace gossi\codegen\tests\model;

use gossi\codegen\model\PhpProperty;

class PhpPropertyTest extends \PHPUnit_Framework_TestCase {

	public function testSetGetValue() {
		$prop = new PhpProperty('needsName');

		$this->assertNull($prop->getValue());
		$this->assertFalse($prop->hasValue());
		$this->assertSame($prop, $prop->setValue('foo'));
		$this->assertEquals('foo', $prop->getValue());
		$this->assertTrue($prop->hasValue());
		$this->assertSame($prop, $prop->unsetValue());
		$this->assertNull($prop->getValue());
		$this->assertFalse($prop->hasValue());
	}

	public function testSetGetExpression() {
		$prop = new PhpProperty('needsName');

		$this->assertNull($prop->getExpression());
		$this->assertFalse($prop->isExpression());
		$this->assertSame($prop, $prop->setExpression('null'));
		$this->assertEquals('null', $prop->getExpression());
		$this->assertTrue($prop->isExpression());
		$this->assertSame($prop, $prop->unsetExpression());
		$this->assertNull($prop->getExpression());
		$this->assertFalse($prop->isExpression());
	}

	public function testValueAndExpression() {
		$prop = new PhpProperty('needsName');

		$prop->setValue('abc');
		$prop->setExpression('null');

		$this->assertTrue($prop->hasValue());
		$this->assertTrue($prop->isExpression());
	}
}
