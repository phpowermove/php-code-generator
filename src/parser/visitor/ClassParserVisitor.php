<?php
namespace gossi\codegen\parser\visitor;

use gossi\codegen\parser\visitor\parts\StructParserPart;
use PhpParser\Node\Stmt\Class_;

class ClassParserVisitor extends StructParserVisitor {

	use StructParserPart;

	public function visitClass(Class_ $node) {
		$struct = $this->getStruct();

		if ($node->extends !== null) {
			if ($node->extends->getType() === 'Name_FullyQualified') {
				$struct->setParentClassName('\\' . implode('\\', $node->extends->parts));
			} else {
				$struct->setParentClassName(implode('\\', $node->extends->parts));
			}
		}

		foreach ($node->implements as $interface) {
			if ($interface->getType() === 'Name_FullyQualified') {
				$struct->addInterface('\\' . implode('\\', $interface->parts));
			} else {
				$struct->addInterface(implode('\\', $interface->parts));
			}
		}

		$struct->setAbstract($node->isAbstract());
		$struct->setFinal($node->isFinal());
	}
}
