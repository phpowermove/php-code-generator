<?php
namespace gossi\codegen\parser\visitor;

use gossi\codegen\model\PhpClass;
use PhpParser\Node\Stmt\Class_;

class PhpClassVisitor extends AbstractPhpStructVisitor {
	
	public function __construct() {
		parent::__construct(new PhpClass());
	}
	
	/**
	 * @return PhpClass
	 */
	public function getClass() {
		return $this->struct;
	}
	
	protected function visitClass(Class_ $node) {
		$struct = $this->getClass();
		
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