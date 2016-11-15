<?php
namespace gossi\codegen\parser\visitor;

use gossi\codegen\model\PhpConstant;
use gossi\codegen\parser\visitor\parts\MemberParserPart;
use gossi\codegen\parser\visitor\parts\ValueParserPart;
use PhpParser\Comment\Doc;
use PhpParser\Node\Const_;
use PhpParser\Node\Stmt\ClassConst;

class ConstantParserVisitor extends StructParserVisitor {
	
	use MemberParserPart;
	use ValueParserPart;
	
	public function visitConstants(ClassConst $node) {
		$doc = $node->getDocComment();
		foreach ($node->consts as $const) {
			$this->visitConstant($const, $doc);
		}
	}
	
	public function visitConstant(Const_ $node, Doc $doc = null) {
		$const = new PhpConstant($node->name);
		$this->parseValue($const, $node);
		$this->parseMemberDocblock($const, $doc);
	
		$this->struct->setConstant($const);
	}
}