<?php declare(strict_types=1);
/*
 * This file is part of the php-code-generator package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license Apache-2.0
 */

namespace gossi\codegen\tests\generator;

use gossi\codegen\generator\CodeGenerator;
use gossi\codegen\model\PhpTrait;
use PHPUnit\Framework\TestCase;

/**
 * @group generator
 */
class TraitGeneratorTest extends TestCase {
	public function testSignature(): void {
		$expected = "trait MyTrait {\n}\n";

		$trait = PhpTrait::create('MyTrait');
		$generator = new CodeGenerator(['generateEmptyDocblock' => false]);
		$code = $generator->generate($trait);

		$this->assertEquals($expected, $code);
	}
}
