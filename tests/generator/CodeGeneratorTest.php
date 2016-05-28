<?php
namespace gossi\codegen\tests\generator;

use gossi\codegen\generator\CodeFileGenerator;
use gossi\codegen\generator\CodeGenerator;
use gossi\codegen\model\PhpClass;
use gossi\codegen\model\PhpConstant;
use gossi\codegen\model\PhpFunction;
use gossi\codegen\model\PhpMethod;
use gossi\codegen\model\PhpParameter;
use gossi\codegen\model\PhpProperty;

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
		$expected = 'function fn($a) {
}';
		$fn = PhpFunction::create('fn')->addParameter(PhpParameter::create('a')->setType('int'));

		$codegen = new CodeGenerator(['generateDocblock' => false, 'generateEmptyDocblock' => false]);
		$code = $codegen->generate($fn);

		$this->assertEquals($expected, $code);
	}

	public function testNonPrimitveParameter() {
		$expected = 'function fn(Response $a) {
}';
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
		$expected = 'function fn(int $a) {
}';
		$fn = PhpFunction::create('fn')->addParameter(PhpParameter::create('a')->setType('int'));

		$codegen = new CodeGenerator(['generateDocblock' => false, 'generateEmptyDocblock' => false, 'generateScalarTypeHints' => true]);
		$code = $codegen->generate($fn);

		$this->assertEquals($expected, $code);
	}

	public function testFunctionReturnTypeHinting() {
		$expected = 'function fn($a): int {
}';
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

		$expected = "class GenerationTestClass {\n\n\tpublic function a(int \$b) {\n\t}\n}";

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

		$expected = "class GenerationTestClass {\n\n\tpublic function a(\$b): int {\n\t}\n}";

		$codegen = new CodeGenerator(['generateDocblock' => false, 'generateEmptyDocblock' => false, 'generateReturnTypeHints' => true]);
		$code = $codegen->generate($class);

		$this->assertEquals($expected, $code);
	}

	public function testStrictTypesDeclaration() {
		$expected = "<?php\ndeclare(strict_types=1);\n\nfunction fn(\$a) {\n}\n";
		$fn = PhpFunction::create('fn')->addParameter(PhpParameter::create('a'));

		$codegen = new CodeFileGenerator(['generateDocblock' => false, 'generateEmptyDocblock' => false, 'declareStrictTypes' => true]);
		$code = $codegen->generate($fn);

		$this->assertEquals($expected, $code);
	}

	public function testSortingUseStatement() {
		$class = new PhpClass('ClassWithSortedUseStatements');

		$class->addUseStatement('phootwork\lang\Comparable');
		$class->addUseStatement('phootwork\lang\Text');
		$class->addUseStatement('Doctrine\Instantiator\Instantiator');
		$class->addUseStatement('phootwork\collection\ArrayList');
		$class->addUseStatement('Symfony\Component\Finder\Finder');
		$class->addUseStatement('phootwork\file\Path');
		$class->addUseStatement('gossi\docblock\Docblock');
		$class->addUseStatement('phootwork\tokenizer\PhpTokenizer');
		$class->addUseStatement('phootwork\collection\Map');

		$codegen = new CodeFileGenerator();
		$code = $codegen->generate($class);

		$this->assertEquals($this->getContent('ClassWithSortedUseStatements.php'), $code);
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
				)
			);

		$codegen = new CodeFileGenerator(['generateDocblock' => false]);
		$code = $codegen->generate($class);

		$this->assertEquals($this->getContent('ClassWithExpression.php'), $code);
	}
}
