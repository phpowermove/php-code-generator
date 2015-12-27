<?php
namespace gossi\codegen\parser\visitor;

use gossi\codegen\model\PhpTrait;
use PhpParser\Node\Stmt\Trait_;

class PhpTraitVisitor extends AbstractPhpStructVisitor {
	
	public function __construct() {
		parent::__construct(new PhpTrait());
	}
	
	/**
	 * @return PhpTrait
	 */
	public function getTrait() {
		return $this->struct;
	}
	
	protected function visitTrait(Trait_ $node) {
// 		$struct = $this->getTrait();
	}
}