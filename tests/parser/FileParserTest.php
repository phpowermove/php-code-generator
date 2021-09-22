<?php
namespace phpowermove\codegen\tests\parser;

use phpowermove\codegen\model\PhpClass;
use phpowermove\codegen\parser\FileParser;
use phpowermove\codegen\parser\visitor\ClassParserVisitor;
use PHPUnit\Framework\TestCase;

/**
 * @group parser
 */
class FileParserTest extends TestCase {

	public function testVisitors() {
		$struct = new PhpClass();
		$visitor = new ClassParserVisitor($struct);
		$parser = new FileParser('dummy-file');
		$parser->addVisitor($visitor);
		$this->assertTrue($parser->hasVisitor($visitor));
		$parser->removeVisitor($visitor);
		$this->assertFalse($parser->hasVisitor($visitor));
	}

	/**
	 * @expectedException phootwork\file\exception\FileNotFoundException
	 */
	public function testGetConstantThrowsExceptionWhenConstantDoesNotExist() {
		$parser = new FileParser('file-not-found');
		$parser->parse();
	}
}
