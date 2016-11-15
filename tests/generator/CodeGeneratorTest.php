<?php
namespace gossi\codegen\tests\generator;

use gossi\codegen\config\CodeGeneratorConfig;
use gossi\codegen\generator\CodeGenerator;

/**
 * @group generator
 */
class CodeGeneratorTest extends \PHPUnit_Framework_TestCase {
	
	public function testConfig() {
		$generator = new CodeGenerator(null);
		$this->assertTrue($generator->getConfig() instanceof CodeGeneratorConfig);
		
		$config = new CodeGeneratorConfig();
		$generator = new CodeGenerator($config);
		$this->assertSame($config, $generator->getConfig());
	}
}
