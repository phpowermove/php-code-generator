<?php
namespace gossi\codegen\tests\generator;

use PHPUnit\Framework\TestCase;
use gossi\codegen\generator\ModelGenerator;
use gossi\codegen\model\PhpTrait;

/**
 * @group generator
 */
class TraitGeneratorTest extends TestCase {

	public function testSignature() {
		$expected = 'trait MyTrait {' . "\n" . '}';

		$trait = PhpTrait::create('MyTrait');
		$generator = new ModelGenerator();
		$code = $generator->generate($trait);

		$this->assertEquals($expected, $code);
	}

}
