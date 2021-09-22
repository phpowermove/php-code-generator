<?php
namespace phpowermove\codegen\tests\generator;

use phpowermove\codegen\config\CodeFileGeneratorConfig;
use phpowermove\codegen\generator\CodeFileGenerator;
use phpowermove\codegen\model\PhpClass;
use phpowermove\codegen\model\PhpConstant;
use phpowermove\codegen\model\PhpFunction;
use phpowermove\codegen\model\PhpMethod;
use phpowermove\codegen\model\PhpParameter;
use phpowermove\codegen\model\PhpProperty;
use phpowermove\codegen\tests\Fixtures;
use phpowermove\codegen\tests\parts\TestUtils;
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
			->setProperty(PhpProperty::create('bembel')
				->setExpression("['ebbelwoi' => 'is eh besser', 'als wie' => 'bier']")
			)
			->setMethod(PhpMethod::create('getValue')
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
