<?php
namespace gossi\codegen\parser\visitor;

use gossi\codegen\parser\visitor\parts\StructParserPart;
use PhpParser\Node\Stmt\Class_;

class ClassParserVisitor extends StructParserVisitor {
	
	use StructParserPart;

	public function visitClass(Class_ $node) {
		$struct = $this->getStruct();
		
		if ($node->extends !== null) {
			$struct->setParentClassName(implode('\\', $node->extends->parts));
		}

		foreach ($node->implements as $name) {
			$struct->addInterface(implode('\\', $name->parts));
		}

		$struct->setAbstract($node->isAbstract());
		$struct->setFinal($node->isFinal());
	}
}
