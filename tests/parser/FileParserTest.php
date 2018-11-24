<?php
namespace gossi\codegen\tests\parser;

use PHPUnit\Framework\TestCase;
use gossi\codegen\model\PhpClass;
use gossi\codegen\parser\FileParser;
use gossi\codegen\parser\visitor\ClassParserVisitor;

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