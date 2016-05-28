<?php
namespace gossi\codegen\tests\generator;

use gossi\codegen\generator\GeneratorStrategy;
use gossi\codegen\model\PhpClass;
use gossi\codegen\model\PhpMethod;
use gossi\codegen\model\PhpProperty;

class GeneratorStrategyTest extends \PHPUnit_Framework_TestCase {

	public function testGenerate() {
		$strategy = new GeneratorStrategy();
		$strategy->setConstantSortFunc(function ($a, $b) {
			return strcasecmp($a, $b);
		});
		$strategy->setMethodSortFunc($func = function ($a, $b) {
			return strcasecmp($a->getName(), $b->getName());
		});
		$strategy->setPropertySortFunc($func);

		$this->assertEquals($this->getContent('GenerationTestClass_A.php'), $strategy->generate($this->getClass()));
	}

	public function testGenerateChangedConstantOrder() {
		$strategy = new GeneratorStrategy();
		$strategy->setConstantSortFunc(function ($a, $b) {
			return -1 * strcasecmp($a, $b);
		});
		$strategy->setMethodSortFunc($func = function ($a, $b) {
			return strcasecmp($a->getName(), $b->getName());
		});
		$strategy->setPropertySortFunc($func);

		$this->assertEquals($this->getContent('GenerationTestClass_B.php'), $strategy->generate($this->getClass()));
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
}
