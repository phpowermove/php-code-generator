<?php
namespace gossi\codegen\tests\parser;

use gossi\codegen\model\PhpClass;
use gossi\codegen\tests\parts\ValueTests;

/**
 * @group parser
 */
class ParameterParserTest extends \PHPUnit_Framework_TestCase {
	
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
