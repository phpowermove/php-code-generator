<?php
namespace gossi\codegen\tests\generator;

use gossi\codegen\config\CodeFileGeneratorConfig;
use gossi\codegen\generator\CodeFileGenerator;
use gossi\codegen\model\PhpClass;
use gossi\codegen\model\PhpConstant;
use gossi\codegen\model\PhpFunction;
use gossi\codegen\model\PhpMethod;
use gossi\codegen\model\PhpParameter;
use gossi\codegen\model\PhpProperty;
use gossi\codegen\tests\Fixtures;
use gossi\codegen\tests\parts\TestUtils;
use PHPUnit\Framework\TestCase;

/**
 * @group generator
 */
class CodeFileGeneratorTest extends TestCase {

	use TestUtils;

	public function testStrictTypesDeclaration() {
		$expected = "<?php\ndeclare(strict_types=1);\n\nfunction fn(\$a) {\n}\n";
		$fn = PhpFunction::create('fn')->addParameter(PhpParameter::create('a'));

		$codegen = new CodeFileGenerator(['generateDocblock' => false, 'generateEmptyDocblock' => false, 'declareStrictTypes' => true]);
		$code = $codegen->generate($fn);

		$this->assertEquals($expected, $code);
	}

	public function testExpression() {
		$class = new PhpClass('ClassWithExpression');
		$class
			->setConstant(PhpConstant::create('FOO', 'BAR'))
			->addProperty(PhpProperty::create('bembel')
                                     ->setExpression("['ebbelwoi' => 'is eh besser', 'als wie' => 'bier']")
			)
			->addMethod(PhpMethod::create('getValue')
                                 ->addParameter(PhpParameter::create('arr')
					->setExpression('[self::FOO => \'baz\']')
			));

		$codegen = new CodeFileGenerator(['generateDocblock' => false]);
		$code = $codegen->generate($class);

		$this->assertEquals($this->getGeneratedContent('ClassWithExpression.php'), $code);
	}

	public function testDocblocks() {
		$generator = new CodeFileGenerator([
			'headerComment' => 'hui buuh',
			'headerDocblock' => 'woop'
		]);

		$class = new PhpClass('Dummy');
		$code = $generator->generate($class);

		$this->assertEquals($this->getGeneratedContent('Dummy.php'), $code);
	}

	public function testEntity() {
		$class = Fixtures::createEntity();

		$generator = new CodeFileGenerator(['generateDocblock' => true, 'generateEmptyDocblock' => false]);
		$code = $generator->generate($class);

		$this->assertEquals($this->getFixtureContent('Entity.php'), $code);
	}

	public function testConfig() {
		$generator = new CodeFileGenerator(null);
		$this->assertTrue($generator->getConfig() instanceof CodeFileGeneratorConfig);

		$config = new CodeFileGeneratorConfig();
		$generator = new CodeFileGenerator($config);
		$this->assertSame($config, $generator->getConfig());
	}
}
