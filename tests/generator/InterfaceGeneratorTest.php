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
use gossi\codegen\model\PhpInterface;
use PHPUnit\Framework\TestCase;

/**
 * @group generator
 */
class InterfaceGeneratorTest extends TestCase {
	public function testSignature(): void {
		$expected = "interface MyInterface {\n}\n";

		$interface = PhpInterface::create('MyInterface');
		$generator = new CodeGenerator(['generateEmptyDocblock' => false]);
		$code = $generator->generate($interface);

		$this->assertEquals($expected, $code);
	}

	public function testExtends(): void {
		$generator = new CodeGenerator(['generateEmptyDocblock' => false]);

		$expected = "interface MyInterface extends \Iterator {\n}\n";
		$interface = PhpInterface::create('MyInterface')->addInterface('\Iterator');
		$this->assertEquals($expected, $generator->generate($interface));

		$expected = "interface MyInterface extends \Iterator, \ArrayAccess {\n}\n";
		$interface = PhpInterface::create('MyInterface')->addInterface('\Iterator')->addInterface('\ArrayAccess');
		$this->assertEquals($expected, $generator->generate($interface));
	}
}
