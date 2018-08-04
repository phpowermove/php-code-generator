<?php
namespace gossi\codegen\tests\generator;

use gossi\codegen\generator\CodeFileGenerator;
use gossi\codegen\generator\ModelGenerator;
use gossi\codegen\model\PhpClass;
use gossi\codegen\tests\Fixtures;
use gossi\codegen\tests\parts\TestUtils;
use gossi\codegen\generator\CodeGenerator;

/**
 * @group generator
 */
class ClassGeneratorTest extends \PHPUnit_Framework_TestCase {

	use TestUtils;

	public function testSignature() {
		$expected = 'class MyClass {' . "\n" . '}';

		$class = PhpClass::create('MyClass');
		$generator = new ModelGenerator();
		$code = $generator->generate($class);

		$this->assertEquals($expected, $code);
	}

	public function testAbstract() {
		$expected = 'abstract class MyClass {' . "\n" . '}';

		$class = PhpClass::create('MyClass')->setAbstract(true);
		$generator = new ModelGenerator();
		$code = $generator->generate($class);

		$this->assertEquals($expected, $code);
	}

	public function testFinal() {
		$expected = 'final class MyClass {' . "\n" . '}';

		$class = PhpClass::create('MyClass')->setFinal(true);
		$generator = new ModelGenerator();
		$code = $generator->generate($class);

		$this->assertEquals($expected, $code);
	}

	public function testInterfaces() {
		$generator = new ModelGenerator();

		$expected = 'class MyClass implements \Iterator {' . "\n" . '}';
		$class = PhpClass::create('MyClass')->addInterface('\Iterator');
		$this->assertEquals($expected, $generator->generate($class));

		$expected = 'class MyClass implements \Iterator, \ArrayAccess {' . "\n" . '}';
		$class = PhpClass::create('MyClass')->addInterface('\Iterator')->addInterface('\ArrayAccess');
		$this->assertEquals($expected, $generator->generate($class));
	}

	public function testParent() {
		$expected = 'class MyClass extends MyParent {' . "\n" . '}';

		$class = PhpClass::create('MyClass')->setParentClassName('MyParent');
		$generator = new ModelGenerator();
		$code = $generator->generate($class);

		$this->assertEquals($expected, $code);
	}

	public function testUseStatements() {
		$class = new PhpClass('Foo\\Bar');
		$class->addUseStatement('Bam\\Baz');

		$codegen = new CodeFileGenerator(['generateDocblock' => false, 'generateEmptyDocblock' => false]);
		$code = $codegen->generate($class);

		$this->assertEquals($this->getGeneratedContent('FooBar.php'), $code);

		$class = new PhpClass('Foo\\Bar');
		$class->addUseStatement('Bam\\Baz', 'BamBaz');

		$codegen = new CodeFileGenerator(['generateDocblock' => false, 'generateEmptyDocblock' => false]);
		$code = $codegen->generate($class);

		$this->assertEquals($this->getGeneratedContent('FooBarWithAlias.php'), $code);

		$class = new PhpClass('Foo');
		$class->addUseStatement('Bar');

		$generator = new ModelGenerator();
		$code = $generator->generate($class);
		$expected = 'class Foo {' . "\n" . '}';

		$this->assertEquals($expected, $code);
	}

	public function testABClass() {
		$class = Fixtures::createABClass();

		$modelGenerator = new ModelGenerator();
		$modelCode = $modelGenerator->generate($class);
		$this->assertEquals($this->getGeneratedContent('ABClass.php'), $modelCode);
		$generator = new CodeGenerator(['generateDocblock' => false]);
		$code = $generator->generate($class);
		$this->assertEquals($modelCode, $code);

		$modelGenerator = new ModelGenerator(['generateDocblock' => true]);
		$modelCode = $modelGenerator->generate($class);
		$this->assertEquals($this->getGeneratedContent('ABClassWithComments.php'), $modelCode);
		$generator = new CodeGenerator(['generateDocblock' => true]);
		$code = $generator->generate($class);
		$this->assertEquals($modelCode, $code);
	}

	public function testRequireTraitsClass() {
		$class = PhpClass::create('RequireTraitsClass')
			->addRequiredFile('FooBar.php')
			->addRequiredFile('ABClass.php')
			->addTrait('Iterator');

		$generator = new ModelGenerator();
		$code = $generator->generate($class);
		$this->assertEquals($this->getGeneratedContent('RequireTraitsClass.php'), $code);
	}

	public function testMyCollection() {
		$class = PhpClass::fromFile(__DIR__ . '/../fixtures/MyCollection.php');

		$generator = new CodeFileGenerator(['generateDocblock' => false]);
		$code = $generator->generate($class);

		$this->assertEquals($this->getFixtureContent('MyCollection.php'), $code);
	}

	public function testMyCollection2() {
		$class = PhpClass::fromFile(__DIR__ . '/../fixtures/MyCollection2.php');

		$generator = new CodeFileGenerator(['generateDocblock' => false]);
		$code = $generator->generate($class);

		$this->assertEquals($this->getFixtureContent('MyCollection2.php'), $code);
	}

}
