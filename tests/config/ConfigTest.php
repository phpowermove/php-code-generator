<?php
namespace phpowermove\codegen\tests\config;

use phpowermove\code\profiles\Profile;
use phpowermove\codegen\config\CodeFileGeneratorConfig;
use phpowermove\codegen\config\CodeGeneratorConfig;
use phpowermove\codegen\generator\CodeGenerator;
use phpowermove\docblock\Docblock;
use phootwork\lang\ComparableComparator;
use phootwork\lang\Comparator;
use PHPUnit\Framework\TestCase;

/**
 * @group config
 */
class ConfigTest extends TestCase {

	public function testCodeGeneratorConfigDefaults() {
		$config = new CodeGeneratorConfig();

		$this->assertTrue($config->getGenerateDocblock());
		$this->assertTrue($config->getGenerateEmptyDocblock());
		$this->assertFalse($config->getGenerateScalarTypeHints());
		$this->assertFalse($config->getGenerateReturnTypeHints());
		$this->assertTrue($config->isSortingEnabled());
		$this->assertFalse($config->isFormattingEnabled());
		$this->assertTrue($config->getProfile() instanceof Profile);
		$this->assertEquals(CodeGenerator::SORT_USESTATEMENTS_DEFAULT, $config->getUseStatementSorting());
		$this->assertEquals(CodeGenerator::SORT_CONSTANTS_DEFAULT, $config->getConstantSorting());
		$this->assertEquals(CodeGenerator::SORT_PROPERTIES_DEFAULT, $config->getPropertySorting());
		$this->assertEquals(CodeGenerator::SORT_METHODS_DEFAULT, $config->getMethodSorting());
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

		$config->setProfile('psr-2');
		$this->assertTrue($config->getProfile() instanceof Profile);

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

		$config->setGenerateNullableTypes(true);
		$this->assertTrue($config->getGenerateNullableTypes());

		$config->setUseStatementSorting(false);
		$this->assertFalse($config->getUseStatementSorting());

		$config->setConstantSorting('abc');
		$this->assertEquals('abc', $config->getConstantSorting());

		$config->setPropertySorting(new ComparableComparator());
		$this->assertTrue($config->getPropertySorting() instanceof Comparator);

		$cmp = function ($a, $b) {
			return strcmp($a, $b);
		};
		$config->setMethodSorting($cmp);
		$this->assertSame($cmp, $config->getMethodSorting());

		$config->setSortingEnabled(false);
		$this->assertFalse($config->isSortingEnabled());

		$config->setFormattingEnabled(true);
		$this->assertTrue($config->isFormattingEnabled());
	}

	public function testCodeFileGeneratorConfigDefaults() {
		$config = new CodeFileGeneratorConfig();

		$this->assertNull($config->getHeaderComment());
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

		$docblock = new Docblock();
		$this->assertSame($docblock, $config->setHeaderDocblock($docblock)->getHeaderDocblock());

		$this->assertFalse($config->setBlankLineAtEnd(false)->getBlankLineAtEnd());
		$this->assertTrue($config->setDeclareStrictTypes(true)->getDeclareStrictTypes());
	}
}
