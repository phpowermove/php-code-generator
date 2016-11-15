<?php
namespace gossi\codegen\tests\generator;

use gossi\codegen\generator\ModelGenerator;
use gossi\codegen\model\PhpConstant;

/**
 * @group generator
 */
class ConstantGeneratorTest extends \PHPUnit_Framework_TestCase {

	public function testValues() {
		$generator = new ModelGenerator();
		
		$prop = PhpConstant::create('FOO')->setValue('string');
		$this->assertEquals('const FOO = \'string\';'."\n", $generator->generate($prop));
		
		$prop = PhpConstant::create('FOO')->setValue(300);
		$this->assertEquals('const FOO = 300;'."\n", $generator->generate($prop));
		
		$prop = PhpConstant::create('FOO')->setValue(162.5);
		$this->assertEquals('const FOO = 162.5;'."\n", $generator->generate($prop));
		
		$prop = PhpConstant::create('FOO')->setValue(true);
		$this->assertEquals('const FOO = true;'."\n", $generator->generate($prop));
		
		$prop = PhpConstant::create('FOO')->setValue(false);
		$this->assertEquals('const FOO = false;'."\n", $generator->generate($prop));
		
		$prop = PhpConstant::create('FOO')->setValue(null);
		$this->assertEquals('const FOO = null;'."\n", $generator->generate($prop));
		
		$prop = PhpConstant::create('FOO')->setValue(PhpConstant::create('BAR'));
		$this->assertEquals('const FOO = BAR;'."\n", $generator->generate($prop));
		
		$prop = PhpConstant::create('FOO')->setExpression("['bar' => 'baz']");
		$this->assertEquals('const FOO = [\'bar\' => \'baz\'];'."\n", $generator->generate($prop));
	}

}
