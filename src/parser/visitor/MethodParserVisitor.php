<?php
declare(strict_types=1);

namespace phpowermove\codegen\parser\visitor;

use phpowermove\codegen\model\PhpMethod;
use phpowermove\codegen\model\PhpParameter;
use phpowermove\codegen\parser\PrettyPrinter;
use phpowermove\codegen\parser\visitor\parts\MemberParserPart;
use phpowermove\codegen\parser\visitor\parts\ValueParserPart;
use phpowermove\docblock\tags\ParamTag;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\ClassMethod;

class MethodParserVisitor extends StructParserVisitor {

	use MemberParserPart;
	use ValueParserPart;

	public function visitMethod(ClassMethod $node) {
		$m = new PhpMethod($node->name->name);
		$m->setAbstract($node->isAbstract());
		$m->setFinal($node->isFinal());
		$m->setVisibility($this->getVisibility($node));
		$m->setStatic($node->isStatic());
		$m->setReferenceReturned($node->returnsByRef());

		$this->parseMemberDocblock($m, $node->getDocComment());
		$this->parseParams($m, $node);
		$this->parseType($m, $node);
		$this->parseBody($m, $node);

		$this->struct->setMethod($m);
	}

	private function parseParams(PhpMethod $m, ClassMethod $node) {
		$params = $m->getDocblock()->getTags('param');
		foreach ($node->params as $param) {
			$name = $param->var ? $param->var->name : $param->name;

			$p = new PhpParameter();
			$p->setName($name);
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
	}

	private function parseType(PhpMethod &$m, ClassMethod $node) {
		$returns = $m->getDocblock()->getTags('return');
		if ($returns->size() > 0) {
			$return = $returns->get(0);
			$m->setType($return->getType(), $return->getDescription());
		}
	}

	private function parseBody(PhpMethod &$m, ClassMethod $node) {
		$stmts = $node->getStmts();
		if (is_array($stmts) && count($stmts)) {
			$prettyPrinter = new PrettyPrinter();
			$m->setBody($prettyPrinter->prettyPrint($stmts));
		}
	}
}
