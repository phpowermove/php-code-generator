<?php
namespace gossi\codegen\tests\config;

use gossi\codegen\config\CodeFileGeneratorConfig;
use gossi\codegen\config\CodeGeneratorConfig;
use gossi\docblock\Docblock;

class ConfigTest extends \PHPUnit_Framework_TestCase {

	public function testCodeGeneratorConfigDefaults() {
		$config = new CodeGeneratorConfig();

		$this->assertTrue($config->getGenerateDocblock());
		$this->assertTrue($config->getGenerateEmptyDocblock());
		$this->assertFalse($config->getGenerateScalarTypeHints());
		$this->assertFalse($config->getGenerateReturnTypeHints());
	}

	public function testCodeGeneratorConfigDisableDocblock() {
		$config = new CodeGeneratorConfig(['generateDocblock' => false]);

		$this->assertFalse($config->getGenerateDocblock());
		$this->assertFalse($config->getGenerateEmptyDocblock());
		$this->assertFalse($config->getGenerateScalarTypeHints());
		$this->assertFalse($config->getGenerateReturnTypeHints());
	}

	public function testCodeGeneratorConfigSetters() {
		$config = new CodeGeneratorConfig();

		$config->setGenerateDocblock(false);
		$this->assertFalse($config->getGenerateDocblock());
		$this->assertFalse($config->getGenerateEmptyDocblock());

		$config->setGenerateEmptyDocblock(true);
		$this->assertTrue($config->getGenerateDocblock());
		$this->assertTrue($config->getGenerateEmptyDocblock());

		$config->setGenerateEmptyDocblock(false);
		$this->assertTrue($config->getGenerateDocblock());
		$this->assertFalse($config->getGenerateEmptyDocblock());

		$config->setGenerateReturnTypeHints(true);
		$this->assertTrue($config->getGenerateReturnTypeHints());

		$config->setGenerateScalarTypeHints(true);
		$this->assertTrue($config->getGenerateScalarTypeHints());
	}

	public function testCodeFileGeneratorConfigDefaults() {
		$config = new CodeFileGeneratorConfig();

		$this->assertEmpty($config->getHeaderComment());
		$this->assertNull($config->getHeaderDocblock());
		$this->assertTrue($config->getBlankLineAtEnd());
		$this->assertFalse($config->getDeclareStrictTypes());
	}

	public function testCodeFileGeneratorConfigDeclareStrictTypes() {
		$config = new CodeFileGeneratorConfig(['declareStrictTypes' => true]);

		$this->assertTrue($config->getDeclareStrictTypes());
		$this->assertTrue($config->getGenerateReturnTypeHints());
		$this->assertTrue($config->getGenerateScalarTypeHints());
	}

	public function testCodeFileGeneratorConfigSetters() {
		$config = new CodeFileGeneratorConfig();

		$this->assertEquals('hello world', $config->setHeaderComment('hello world')->getHeaderComment());

		$docblock = new Docblock();
		$this->assertSame($docblock, $config->setHeaderDocblock($docblock)->getHeaderDocblock());

		$this->assertFalse($config->setBlankLineAtEnd(false)->getBlankLineAtEnd());
		$this->assertTrue($config->setDeclareStrictTypes(true)->getDeclareStrictTypes());
	}
}