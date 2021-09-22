<?php
declare(strict_types=1);

namespace phpowermove\codegen\parser\visitor;

use phpowermove\codegen\parser\visitor\parts\StructParserPart;
use PhpParser\Node\Stmt\Interface_;

class InterfaceParserVisitor extends StructParserVisitor {

	use StructParserPart;

	public function visitInterface(Interface_ $node) {
		foreach ($node->extends as $name) {
			$this->struct->addInterface(implode('\\', $name->parts));
		}
	}
}
