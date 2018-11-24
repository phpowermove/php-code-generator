<?php
namespace gossi\codegen\tests\model;

use PHPUnit\Framework\TestCase;
use gossi\codegen\model\PhpProperty;
use gossi\codegen\tests\parts\ValueTests;

/**
 * @group model
 */
class PropertyTest extends TestCase {

	use ValueTests;

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

	public function testValues() {
		$this->isValueString(PhpProperty::create('x')->setValue('hello'));
		$this->isValueInteger(PhpProperty::create('x')->setValue(2));
		$this->isValueFloat(PhpProperty::create('x')->setValue(0.2));
		$this->isValueBool(PhpProperty::create('x')->setValue(false));
		$this->isValueNull(PhpProperty::create('x')->setValue(null));
	}

	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testInvalidValue() {
		PhpProperty::create('x')->setValue(new \stdClass());
	}
}
