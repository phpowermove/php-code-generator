<?php
namespace gossi\codegen\tests\parts;

use gossi\codegen\model\ValueInterface;

trait ValueTests {
	
	protected function isValueString(ValueInterface $obj) {
		$this->assertTrue(is_string($obj->getValue()));
	}
	
	protected function isValueInteger(ValueInterface $obj) {
		$this->assertTrue(is_int($obj->getValue()));
	}
	
	protected function isValueFloat(ValueInterface $obj) {
		$this->assertTrue(is_float($obj->getValue()));
	}
	
	protected function isValueNumber(ValueInterface $obj) {
		$this->assertTrue(is_numeric($obj->getValue()));
	}
	
	protected function isValueBool(ValueInterface $obj) {
		$this->assertTrue(is_bool($obj->getValue()));
	}
	
	protected function isValueNull(ValueInterface $obj) {
		$this->assertNull($obj->getValue());
	}
}
