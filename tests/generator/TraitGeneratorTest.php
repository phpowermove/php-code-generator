<?php
namespace phpowermove\codegen\tests\generator;

use phpowermove\codegen\generator\ModelGenerator;
use phpowermove\codegen\model\PhpTrait;
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
