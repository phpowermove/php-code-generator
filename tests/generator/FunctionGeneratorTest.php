<?php
namespace phpowermove\codegen\tests\generator;

use phpowermove\codegen\generator\ModelGenerator;
use phpowermove\codegen\model\PhpFunction;
use phpowermove\codegen\model\PhpParameter;
use PHPUnit\Framework\TestCase;

/**
 * @group generator
 */
class FunctionGeneratorTest extends TestCase {

	public function testReferenceReturned() {
		$expected = "function & foo() {\n}\n";

		$method = PhpFunction::create('foo')->setReferenceReturned(true);
		$generator = new ModelGenerator();
		$code = $generator->generate($method);

		$this->assertEquals($expected, $code);
	}

	public function testParameters() {
		$generator = new ModelGenerator();

		$method = PhpFunction::create('foo')->addParameter(PhpParameter::create('bar'));
		$this->assertEquals("function foo(\$bar) {\n}\n", $generator->generate($method));

		$method = PhpFunction::create('foo')
			->addParameter(PhpParameter::create('bar'))
			->addParameter(PhpParameter::create('baz'));
		$this->assertEquals("function foo(\$bar, \$baz) {\n}\n", $generator->generate($method));
	}

	public function testReturnType() {
		$expected = "function foo(): int {\n}\n";
		$generator = new ModelGenerator(['generateReturnTypeHints' => true, 'generateDocblock' => false]);

		$method = PhpFunction::create('foo')->setType('int');
		$this->assertEquals($expected, $generator->generate($method));
	}

}
