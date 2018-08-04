<?php
namespace gossi\codegen\parser\visitor;

use gossi\codegen\model\PhpMethod;
use gossi\codegen\model\PhpParameter;
use gossi\codegen\parser\PrettyPrinter;
use gossi\codegen\parser\visitor\parts\MemberParserPart;
use gossi\codegen\parser\visitor\parts\ValueParserPart;
use gossi\docblock\tags\ParamTag;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\ClassMethod;

class MethodParserVisitor extends StructParserVisitor {

	use MemberParserPart;
	use ValueParserPart;

	public function visitMethod(ClassMethod $node) {
		$m = new PhpMethod($node->name);
		$m->setAbstract($node->isAbstract());
		$m->setFinal($node->isFinal());
		$m->setVisibility($this->getVisibility($node));
		$m->setStatic($node->isStatic());
		$m->setReferenceReturned($node->returnsByRef());

		// docblock
		if (($doc = $node->getDocComment()) !== null) {
			$m->setDocblock($doc->getReformattedText());
			$docblock = $m->getDocblock();
			$m->setDescription($docblock->getShortDescription());
			$m->setLongDescription($docblock->getLongDescription());
		}

		// params
		$params = $m->getDocblock()->getTags('param');
		foreach ($node->params as $param) {
// 			/* @var $param Param */

			$p = new PhpParameter();
			$p->setName($param->name);
			$p->setPassedByReference($param->byRef);

			if (is_string($param->type)) {
				$p->setType($param->type);
			} else if ($param->type instanceof Name) {
				$p->setType(implode('\\', $param->type->parts));
			}

			$this->parseValue($p, $param);

			$tag = $params->find($p, function (ParamTag $t, $p) {
				return $t->getVariable() == '$' . $p->getName();
			});

			if ($tag !== null) {
				$p->setType($tag->getType(), $tag->getDescription());
			}

			$m->addParameter($p);
		}

		// return type and description
		$returns = $m->getDocblock()->getTags('return');
		if ($returns->size() > 0) {
			$return = $returns->get(0);
			$m->setType($return->getType(), $return->getDescription());
		}

		// body
		$stmts = $node->getStmts();
		if (is_array($stmts) && count($stmts)) {
			$prettyPrinter = new PrettyPrinter();
			$m->setBody($prettyPrinter->prettyPrint($stmts));
		}

		$this->struct->setMethod($m);
	}
}