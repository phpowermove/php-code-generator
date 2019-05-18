<?php
namespace gossi\codegen\tests\generator;

use gossi\codegen\generator\ModelGenerator;
use gossi\codegen\model\PhpTrait;
use PHPUnit\Framework\TestCase;

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
