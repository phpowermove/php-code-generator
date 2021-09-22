<?php
declare(strict_types=1);

namespace phpowermove\codegen\parser\visitor;

use phpowermove\codegen\model\AbstractPhpStruct;
use PhpParser\Comment\Doc;
use PhpParser\Node\Const_;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassConst;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Interface_;
use PhpParser\Node\Stmt\Namespace_;
use PhpParser\Node\Stmt\Property;
use PhpParser\Node\Stmt\Trait_;
use PhpParser\Node\Stmt\TraitUse;
use PhpParser\Node\Stmt\UseUse;

class StructParserVisitor implements ParserVisitorInterface {

	protected $struct;

	/**
	 * @return AbstractPhpStruct
	 */
	protected function getStruct(): AbstractPhpStruct {
		return $this->struct;
	}

	public function __construct(AbstractPhpStruct $struct) {
		$this->struct = $struct;
	}

	public function visitStruct(ClassLike $node) {}

	public function visitClass(Class_ $node) {}

	public function visitInterface(Interface_ $node) {}

	public function visitTrait(Trait_ $node) {}

	public function visitTraitUse(TraitUse $node) {}

	public function visitConstants(ClassConst $node) {}

	public function visitConstant(Const_ $node, Doc $doc = null) {}

	public function visitProperty(Property $node) {}

	public function visitNamespace(Namespace_ $node) {}

	public function visitUseStatement(UseUse $node) {}

	public function visitMethod(ClassMethod $node) {}
}
