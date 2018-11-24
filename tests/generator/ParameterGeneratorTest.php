<?php
namespace gossi\codegen\tests\generator;

use PHPUnit\Framework\TestCase;
use gossi\codegen\generator\ModelGenerator;
use gossi\codegen\model\PhpConstant;
use gossi\codegen\model\PhpParameter;

/**
 * @group generator
 */
class ParameterGeneratorTest extends TestCase {

	public function testPassedByReference() {
		$expected = '&$foo';

		$param = PhpParameter::create('foo')->setPassedByReference(true);
		$generator = new ModelGenerator();
		$code = $generator->generate($param);

		$this->assertEquals($expected, $code);
	}

	public function testTypeHints() {
		$generator = new ModelGenerator();

		$param = PhpParameter::create('foo')->setType('Request');
		$this->assertEquals('Request $foo', $generator->generate($param));
	}

	public function testPhp5TypeHints() {
		$generator = new ModelGenerator(['generateScalarTypeHints' => false]);

		$param = PhpParameter::create('foo')->setType('string');
		$this->assertEquals('$foo', $generator->generate($param));

		$param = PhpParameter::create('foo')->setType('int');
		$this->assertEquals('$foo', $generator->generate($param));

		$param = PhpParameter::create('foo')->setType('integer');
		$this->assertEquals('$foo', $generator->generate($param));

		$param = PhpParameter::create('foo')->setType('float');
		$this->assertEquals('$foo', $generator->generate($param));

		$param = PhpParameter::create('foo')->setType('double');
		$this->assertEquals('$foo', $generator->generate($param));

		$param = PhpParameter::create('foo')->setType('bool');
		$this->assertEquals('$foo', $generator->generate($param));

		$param = PhpParameter::create('foo')->setType('boolean');
		$this->assertEquals('$foo', $generator->generate($param));

		$param = PhpParameter::create('foo')->setType('mixed');
		$this->assertEquals('$foo', $generator->generate($param));

		$param = PhpParameter::create('foo')->setType('object');
		$this->assertEquals('$foo', $generator->generate($param));

		$param = PhpParameter::create('foo')->setType('resource');
		$this->assertEquals('$foo', $generator->generate($param));
	}

	public function testPhp7TypeHints() {
		$generator = new ModelGenerator(['generateScalarTypeHints' => true]);

		$param = PhpParameter::create('foo')->setType('string');
		$this->assertEquals('string $foo', $generator->generate($param));

		$param = PhpParameter::create('foo')->setType('int');
		$this->assertEquals('int $foo', $generator->generate($param));

		$param = PhpParameter::create('foo')->setType('integer');
		$this->assertEquals('int $foo', $generator->generate($param));

		$param = PhpParameter::create('foo')->setType('float');
		$this->assertEquals('float $foo', $generator->generate($param));

		$param = PhpParameter::create('foo')->setType('double');
		$this->assertEquals('float $foo', $generator->generate($param));

		$param = PhpParameter::create('foo')->setType('bool');
		$this->assertEquals('bool $foo', $generator->generate($param));

		$param = PhpParameter::create('foo')->setType('boolean');
		$this->assertEquals('bool $foo', $generator->generate($param));

		$param = PhpParameter::create('foo')->setType('mixed');
		$this->assertEquals('$foo', $generator->generate($param));

		$param = PhpParameter::create('foo')->setType('object');
		$this->assertEquals('$foo', $generator->generate($param));

		$param = PhpParameter::create('foo')->setType('resource');
		$this->assertEquals('$foo', $generator->generate($param));
	}

	public function testValues() {
		$generator = new ModelGenerator();

		$prop = PhpParameter::create('foo')->setValue('string');
		$this->assertEquals('$foo = \'string\'', $generator->generate($prop));

		$prop = PhpParameter::create('foo')->setValue(300);
		$this->assertEquals('$foo = 300', $generator->generate($prop));

		$prop = PhpParameter::create('foo')->setValue(162.5);
		$this->assertEquals('$foo = 162.5', $generator->generate($prop));

		$prop = PhpParameter::create('foo')->setValue(true);
		$this->assertEquals('$foo = true', $generator->generate($prop));

		$prop = PhpParameter::create('foo')->setValue(false);
		$this->assertEquals('$foo = false', $generator->generate($prop));

		$prop = PhpParameter::create('foo')->setValue(null);
		$this->assertEquals('$foo = null', $generator->generate($prop));

		$prop = PhpParameter::create('foo')->setValue(PhpConstant::create('BAR'));
		$this->assertEquals('$foo = BAR', $generator->generate($prop));

		$prop = PhpParameter::create('foo')->setExpression("['bar' => 'baz']");
		$this->assertEquals('$foo = [\'bar\' => \'baz\']', $generator->generate($prop));
	}

}
