<?php declare(strict_types=1);
/*
 * This file is part of the php-code-generator package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license Apache-2.0
 */

namespace gossi\codegen\parser\visitor;

use gossi\codegen\model\PhpConstant;
use gossi\codegen\parser\visitor\parts\MemberParserPart;
use gossi\codegen\parser\visitor\parts\TypeParserPart;
use gossi\codegen\parser\visitor\parts\ValueParserPart;
use PhpParser\Comment\Doc;
use PhpParser\Node\Const_;
use PhpParser\Node\Stmt\ClassConst;

class ConstantParserVisitor extends StructParserVisitor {
	use MemberParserPart;
	use ValueParserPart;
	use TypeParserPart;

	public function visitConstants(ClassConst $node): void {
		$doc = $node->getDocComment();
		foreach ($node->consts as $const) {
			$this->visitConstant($const, $doc);
		}
	}

	public function visitConstant(Const_ $node, ?Doc $doc = null): void {
		$const = new PhpConstant($node->name->name);
		$this->parseValue($const, $node);
		$this->parseDocblock($const, $doc);
		$this->setTypeFromTag($const, $const->getDocblock()->getTags('var')->get(0));

		$this->struct->setConstant($const);
	}
}
