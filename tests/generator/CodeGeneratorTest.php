<?php
namespace gossi\codegen\tests\generator;

use gossi\codegen\generator\CodeGenerator;
use gossi\codegen\model\PhpClass;
use gossi\codegen\model\PhpMethod;
use gossi\codegen\model\PhpFunction;
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
}
