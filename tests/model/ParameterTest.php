<?php
namespace gossi\codegen\tests\model;

use gossi\codegen\model\PhpFunction;
use gossi\codegen\model\PhpParameter;
use gossi\codegen\tests\parts\ValueTests;
use gossi\codegen\utils\TypeUtils;
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

		$this->assertEmpty($param->getTypes()->toArray());
		$this->assertSame($param, $param->addType('array'));
		$this->assertEquals('array', $param->getTypeExpression());
		$this->assertSame($param, $param->addType('array')->setTypeDescription('boo!'));
		$this->assertEquals('boo!', $param->getTypeDescription());
	}

	public function testSimpleParameter() {
		$function = new PhpFunction();
		$function->addSimpleParameter('param1', 'string');

		$this->assertTrue($function->hasParameter('param1'));
		$this->assertFalse($function->hasParameter('param2'));
		$param1 = $function->getParameter('param1');
		$this->assertEquals('string', $param1->getTypeExpression());
		$this->assertFalse($param1->hasValue());

		$function->addSimpleParameter('param2', 'string', null);

		$this->assertTrue($function->hasParameter('param2'));
		$param2 = $function->getParameter('param2');
		$this->assertEquals('string', $param1->getTypeExpression());
		$this->assertNull($param2->getValue());
	}

	public function testSimpleDescParameter() {
		$function = new PhpFunction();
		$function->addSimpleDescParameter('param1', 'string');

		$this->assertFalse($function->hasParameter('param2'));
		$param1 = $function->getParameter('param1');
		$this->assertEquals('string', $param1->getTypeExpression());
		$this->assertFalse($param1->hasValue());

		$function->addSimpleDescParameter('param2', 'string', 'desc');

		$this->assertTrue($function->hasParameter('param2'));
		$param2 = $function->getParameter('param2');
		$this->assertEquals('string', $param2->getTypeExpression());
		$this->assertFalse($param2->hasValue());

		$function->addSimpleDescParameter('param3', 'string', 'desc', null);

		$this->assertTrue($function->hasParameter('param3'));
		$param3 = $function->getParameter('param3');
		$this->assertEquals('string', $param3->getTypeExpression());
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
