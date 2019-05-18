<?php
namespace gossi\codegen\tests\parts;

use gossi\codegen\model\PhpClass;

trait ModelAssertions {

	private function assertClassWithValues(PhpClass $class) {
		$bar = $class->getProperty('bar');
		$this->assertFalse($bar->getValue());
		$this->assertTrue($bar->hasValue());
		$this->assertNull($bar->getExpression());

		$magic = $class->getProperty('magic');
		$this->assertNull($magic->getValue());
		$this->assertTrue($magic->isExpression());
		$this->assertEquals('__LINE__', $magic->getExpression());

		$null = $class->getProperty('null');
		$this->assertFalse($null->isExpression());
		$this->assertNull($null->getValue());

		$arr = $class->getProperty('arr');
		$this->assertEquals("['papagei' => ['name' => 'Mr. Cottons Papagei']]", $arr->getExpression());
	}

	private function assertClassWithComments(PhpClass $class) {
		$docblock = $class->getDocblock();

		$this->assertEquals($docblock->getShortDescription(), $class->getDescription());
		$this->assertEquals($docblock->getLongDescription(), $class->getLongDescription());

		$this->assertEquals('A class with comments', $docblock->getShortDescription());
		$this->assertEquals('Here is a super dooper long-description', $docblock->getLongDescription());

		$this->assertTrue($docblock->getTags('author')->size() > 0);
		$this->assertTrue($docblock->getTags('since')->size() > 0);

		$FOO = $class->getConstant('FOO');

		$this->assertEquals('Best const ever', $FOO->getDescription());
		$this->assertEquals('Aaaand we go along long', $FOO->getLongDescription());
		$this->assertEquals('baz', $FOO->getTypeDescription());
		$this->assertEquals('string', $FOO->getType());
		$this->assertEquals('bar', $FOO->getValue());

		$propper = $class->getProperty('propper');

		$this->assertEquals('Best prop ever', $propper->getDescription());
		$this->assertEquals('Aaaand we go along long long', $propper->getLongDescription());
		$this->assertEquals('Wer macht sauber?', $propper->getTypeDescription());
		$this->assertEquals('string', $propper->getType());
		$this->assertEquals('Meister', $propper->getValue());

		$setup = $class->getMethod('setup');
		$this->assertEquals('Short desc', $setup->getDescription());
		$this->assertEquals('Looong desc', $setup->getLongDescription());
		$this->assertEquals('true on success and false if it fails', $setup->getTypeDescription());
		$this->assertEquals('bool', $setup->getType());

		$moo = $setup->getParameter('moo');
		$this->assertEquals('makes a cow', $moo->getTypeDescription());
		$this->assertEquals('bool', $moo->getType());

		$foo = $setup->getParameter('foo');
		$this->assertEquals('makes a fow', $foo->getTypeDescription());
		$this->assertEquals('string', $foo->getType());
	}
}
