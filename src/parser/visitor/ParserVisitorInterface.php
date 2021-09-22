<?php
declare(strict_types=1);

namespace phpowermove\codegen\parser\visitor;

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

interface ParserVisitorInterface {

	/**
	 * Visit a struct
	 *
	 * @param ClassLike $node
	 * @return void
	 */
	public function visitStruct(ClassLike $node);

	/**
	 * Visit a class
	 *
	 * @param Class_ $node
	 * @return void
	 */
	public function visitClass(Class_ $node);

	/**
	 * Visit an interface
	 *
	 * @param Interface_ $node
	 * @return void
	 */
	public function visitInterface(Interface_ $node);

	/**
	 * Visit a trait
	 *
	 * @param Trait_ $node
	 * @return void
	 */
	public function visitTrait(Trait_ $node);

	/**
	 * Visit a use statement inside a struct
	 *
	 * @param TraitUse $node
	 * @return void
	 */
	public function visitTraitUse(TraitUse $node);

	/**
	 * Visit class constants
	 *
	 * @param ClassConst $node
	 * @return void
	 */
	public function visitConstants(ClassConst $node);

	/**
	 * Visit a constant
	 *
	 * @param Const_ $node
	 * @param Doc $doc
	 * @return void
	 */
	public function visitConstant(Const_ $node, Doc $doc = null);

	/**
	 * Visit a property
	 *
	 * @param Property $node
	 * @return void
	 */
	public function visitProperty(Property $node);

	/**
	 * Visit a namespace statement
	 *
	 * @param Namespace_ $node
	 * @return void
	 */
	public function visitNamespace(Namespace_ $node);

	/**
	 * Visit a use statement
	 *
	 * @param UseUse $node
	 * @return void
	 */
	public function visitUseStatement(UseUse $node);

	/**
	 * Visit a method
	 *
	 * @param ClassMethod $node
	 * @return void
	 */
	public function visitMethod(ClassMethod $node);
}
