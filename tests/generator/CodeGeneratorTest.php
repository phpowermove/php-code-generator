<?php
namespace phpowermove\codegen\tests\generator;

use phpowermove\codegen\config\CodeGeneratorConfig;
use phpowermove\codegen\generator\CodeGenerator;
use PHPUnit\Framework\TestCase;

/**
 * @group generator
 */
class CodeGeneratorTest extends TestCase {

	public function testConfig() {
		$generator = new CodeGenerator(null);
		$this->assertTrue($generator->getConfig() instanceof CodeGeneratorConfig);

		$config = new CodeGeneratorConfig();
		$generator = new CodeGenerator($config);
		$this->assertSame($config, $generator->getConfig());
	}
}
