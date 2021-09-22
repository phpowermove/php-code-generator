<?php
namespace phpowermove\codegen\tests\parser;

use phpowermove\codegen\model\PhpClass;
use phpowermove\codegen\tests\parts\ValueTests;
use PHPUnit\Framework\TestCase;

/**
 * @group parser
 */
class ParameterParserTest extends TestCase {

	use ValueTests;

	public function testValuesFromFile() {
		$class = PhpClass::fromFile(__DIR__ . '/../fixtures/ValueClass.php');
		$this->assertValueClass($class);
	}

	protected function assertValueClass(PhpClass $class) {
		$values = $class->getMethod('values');
		$this->isValueString($values->getParameter('paramString'));
		$this->isValueInteger($values->getParameter('paramInteger'));
		$this->isValueFloat($values->getParameter('paramFloat'));
		$this->isValueBool($values->getParameter('paramBool'));
		$this->isValueNull($values->getParameter('paramNull'));
	}
}
