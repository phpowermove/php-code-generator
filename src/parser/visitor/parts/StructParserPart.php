<?php declare(strict_types=1);
/*
 * This file is part of the php-code-generator package.
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 *  @license Apache-2.0
 */

namespace gossi\codegen\parser\visitor\parts;

use gossi\codegen\model\AbstractPhpStruct;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\Namespace_;
use PhpParser\Node\Stmt\TraitUse;
use PhpParser\Node\Stmt\UseUse;

trait StructParserPart {

	/**
	 * @return AbstractPhpStruct
	 */
	abstract protected function getStruct(): AbstractPhpStruct;

	public function visitStruct(ClassLike $node): void {
		$struct = $this->getStruct();
		$struct->setName($node->name->name);

		if (($doc = $node->getDocComment()) !== null) {
			$struct->setDocblock($doc->getReformattedText());
			$docblock = $struct->getDocblock();
			$struct->setDescription($docblock->getShortDescription());
			$struct->setLongDescription($docblock->getLongDescription());
		}
	}

	public function visitTraitUse(TraitUse $node): void {
		$struct = $this->getStruct();

		foreach ($node->traits as $trait) {
			$struct->addTrait(implode('\\', $trait->parts));
		}
	}

	public function visitNamespace(Namespace_ $node): void {
		if ($node->name !== null) {
			$this->getStruct()->setNamespace(implode('\\', $node->name->parts));
		}
	}

	public function visitUseStatement(UseUse $node): void {
		$name = implode('\\', $node->name->parts);

		$this->getStruct()->addUseStatement($name, (string) $node->alias?->name);
	}
}
