<?php
namespace phpowermove\codegen\tests\model;

use phpowermove\codegen\model\PhpFunction;
use phpowermove\codegen\model\PhpParameter;
use phpowermove\codegen\tests\parts\ValueTests;
use PHPUnit\Framework\TestCase;

/**
 * @group model
 */
class ParameterTest extends TestCase {

	use ValueTests;

	public function testByReference() {
		$param = new PhpParameter();
		$this->assertFalse($param->isPassedByReference());
		$param->setPassedByReference(true);
		$this->assertTrue($param->isPassedByReference());
		$param->setPassedByReference(false);
		$this->assertFalse($param->isPassedByReference());
	}

	public function testType() {
		$param = new PhpParameter();

		$this->assertNull($param->getType());
		$this->assertSame($param, $param->setType('array'));
		$this->assertEquals('array', $param->getType());
		$this->assertSame($param, $param->setType('array', 'boo!'));
		$this->assertEquals('boo!', $param->getTypeDescription());
	}

	public function testSimpleParameter() {
		$function = new PhpFunction();
		$function->addSimpleParameter('param1', 'string');

		$this->assertTrue($function->hasParameter('param1'));
		$this->assertFalse($function->hasParameter('param2'));
		$param1 = $function->getParameter('param1');
		$this->assertEquals('string', $param1->getType());
		$this->assertFalse($param1->hasValue());

		$function->addSimpleParameter('param2', 'string', null);

		$this->assertTrue($function->hasParameter('param2'));
		$param2 = $function->getParameter('param2');
		$this->assertEquals('string', $param2->getType());
		$this->assertNull($param2->getValue());
	}

	public function testSimpleDescParameter() {
		$function = new PhpFunction();
		$function->addSimpleDescParameter('param1', 'string');

		$this->assertFalse($function->hasParameter('param2'));
		$param1 = $function->getParameter('param1');
		$this->assertEquals('string', $param1->getType());
		$this->assertFalse($param1->hasValue());

		$function->addSimpleDescParameter('param2', 'string', 'desc');

		$this->assertTrue($function->hasParameter('param2'));
		$param2 = $function->getParameter('param2');
		$this->assertEquals('string', $param2->getType());
		$this->assertFalse($param2->hasValue());

		$function->addSimpleDescParameter('param3', 'string', 'desc', null);

		$this->assertTrue($function->hasParameter('param3'));
		$param3 = $function->getParameter('param3');
		$this->assertEquals('string', $param3->getType());
		$this->assertNull($param3->getValue());
	}

	public function testValues() {
		$this->isValueString(PhpParameter::create()->setValue('hello'));
		$this->isValueInteger(PhpParameter::create()->setValue(2));
		$this->isValueFloat(PhpParameter::create()->setValue(0.2));
		$this->isValueBool(PhpParameter::create()->setValue(false));
		$this->isValueNull(PhpParameter::create()->setValue(null));
	}

}
