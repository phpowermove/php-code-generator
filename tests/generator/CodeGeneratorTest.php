<?php
namespace gossi\codegen\tests\generator;

use gossi\codegen\generator\CodeGenerator;
use gossi\codegen\model\PhpClass;
use gossi\codegen\model\PhpMethod;
use gossi\codegen\model\PhpFunction;
use gossi\codegen\model\PhpParameter;
use gossi\codegen\model\PhpProperty;
use gossi\codegen\generator\CodeFileGenerator;

class CodeGeneratorTest extends \PHPUnit_Framework_TestCase {

	public function testGeneratorWithComments() {
		$codegen = new CodeGenerator();
		$code = $codegen->generate($this->getClass());

		$this->assertEquals($this->getContent('CommentedGenerationTestClass.php'), $code);
	}

	public function testGenerator() {
		$codegen = new CodeGenerator(['generateDocblock' => false, 'generateEmptyDocblock' => false]);
		$code = $codegen->generate($this->getClass());

		$this->assertEquals($this->getContent('GenerationTestClass_A.php'), $code);
	}

	/**
	 *
	 * @param string $file
	 */
	private function getContent($file) {
		return file_get_contents(__DIR__ . '/generated/' . $file);
	}

	/**
	 *
	 * @return PhpClass
	 */
	private function getClass() {
		$class = PhpClass::create()
			->setName('GenerationTestClass')
			->setMethod(PhpMethod::create('a'))
			->setMethod(PhpMethod::create('b'))
			->setProperty(PhpProperty::create('a'))
			->setProperty(PhpProperty::create('b'))
			->setConstant('a', 'foo')
			->setConstant('b', 'bar');

		return $class;
	}

	public function testPrimitveParameter() {
		$expected = 'function fn($a)'."\n".'{'."\n".'}';
		$fn = PhpFunction::create('fn')->addParameter(PhpParameter::create('a')->setType('int'));

		$codegen = new CodeGenerator(['generateDocblock' => false, 'generateEmptyDocblock' => false]);
		$code = $codegen->generate($fn);

		$this->assertEquals($expected, $code);
	}

	public function testNonPrimitveParameter() {
		$expected = 'function fn(Response $a)'."\n".'{'."\n".'}';
		$fn = PhpFunction::create('fn')->addParameter(PhpParameter::create('a')->setType('Response'));

		$codegen = new CodeGenerator(['generateDocblock' => false, 'generateEmptyDocblock' => false]);
		$code = $codegen->generate($fn);

		$this->assertEquals($expected, $code);
	}

	public function testUseStatements() {
		$class = new PhpClass('Foo\\Bar');
		$class->addUseStatement('Bam\\Baz');

		$codegen = new CodeFileGenerator(['generateDocblock' => false, 'generateEmptyDocblock' => false]);
		$code = $codegen->generate($class);

		$this->assertEquals($this->getContent('FooBar.php'), $code);
	}

	public function testUseStatementsWithAlias() {
		$class = new PhpClass('Foo\\Bar');
		$class->addUseStatement('Bam\\Baz', 'BamBaz');

		$codegen = new CodeFileGenerator(['generateDocblock' => false, 'generateEmptyDocblock' => false]);
		$code = $codegen->generate($class);

		$this->assertEquals($this->getContent('FooBarWithAlias.php'), $code);
	}

	public function testFunctionScalarTypeHinting() {
		$expected = 'function fn(int $a)'."\n".'{'."\n".'}';
		$fn = PhpFunction::create('fn')->addParameter(PhpParameter::create('a')->setType('int'));

		$codegen = new CodeGenerator(['generateDocblock' => false, 'generateEmptyDocblock' => false, 'generateScalarTypeHints' => true]);
		$code = $codegen->generate($fn);

		$this->assertEquals($expected, $code);
	}

	public function testFunctionReturnTypeHinting() {
		$expected = 'function fn($a): int'."\n".'{'."\n".'}';
		$fn = PhpFunction::create('fn')->addParameter(PhpParameter::create('a')->setType('int'));
		$fn->setType('int');

		$codegen = new CodeGenerator(['generateDocblock' => false, 'generateEmptyDocblock' => false, 'generateReturnTypeHints' => true]);
		$code = $codegen->generate($fn);

		$this->assertEquals($expected, $code);
	}

	public function testMethodScalarTypeHinting() {
		$class = PhpClass::create()
			->setName('GenerationTestClass')
			->setMethod(PhpMethod::create('a')
			->addParameter(PhpParameter::create('b')
			->setType('int')));

		$expected = "class GenerationTestClass\n{\n    public function a(int \$b)\n    {\n    }\n}";

		$codegen = new CodeGenerator(['generateDocblock' => false, 'generateEmptyDocblock' => false, 'generateScalarTypeHints' => true]);
		$code = $codegen->generate($class);

		$this->assertEquals($expected, $code);
	}

	public function testMethodReturnTypeHinting() {
		$class = PhpClass::create()
			->setName('GenerationTestClass')
			->setMethod(PhpMethod::create('a')
				->addParameter(PhpParameter::create('b'))
					->setType('int'));

		$expected = "class GenerationTestClass\n{\n    public function a(\$b): int\n    {\n    }\n}";

		$codegen = new CodeGenerator(['generateDocblock' => false, 'generateEmptyDocblock' => false, 'generateReturnTypeHints' => true]);
		$code = $codegen->generate($class);

		$this->assertEquals($expected, $code);
	}

	public function testStrictTypesDeclaration() {
		$expected = "<?php\ndeclare(strict_types=1);\n\nfunction fn(\$a)\n{\n}\n";
		$fn = PhpFunction::create('fn')->addParameter(PhpParameter::create('a'));

		$codegen = new CodeFileGenerator(['generateDocblock' => false, 'generateEmptyDocblock' => false, 'declareStrictTypes' => true]);
		$code = $codegen->generate($fn);

		$this->assertEquals($expected, $code);
	}
}
