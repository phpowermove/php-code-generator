<?php
namespace gossi\codegen\parser\visitor;

use gossi\codegen\model\PhpInterface;
use PhpParser\Node\Stmt\Interface_;

class PhpInterfaceVisitor extends AbstractPhpStructVisitor {

	public function __construct() {
		parent::__construct(new PhpInterface());
	}

	/**
	 * @return PhpInterface
	 */
	public function getInterface() {
		return $this->struct;
	}

	protected function visitInterface(Interface_ $node) {
		$struct = $this->getInterface();

		foreach ($node->extends as $name) {
			$struct->addInterface(implode('\\', $name->parts));
		}
	}
}
