<?php
declare(strict_types=1);

namespace gossi\codegen\parser\visitor;

use gossi\codegen\model\PhpMethod;
use gossi\codegen\model\PhpParameter;
use gossi\codegen\parser\PrettyPrinter;
use gossi\codegen\parser\visitor\parts\MemberParserPart;
use gossi\codegen\parser\visitor\parts\ValueParserPart;
use gossi\codegen\utils\TypeUtils;
use gossi\docblock\tags\ParamTag;
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

		$this->struct->addMethod($m);
	}

	private function parseParams(PhpMethod $m, ClassMethod $node) {
		$params = $m->getDocblock()->getTags('param');
		foreach ($node->params as $param) {
			$name = $param->var ? $param->var->name : $param->name;

			$p = new PhpParameter();
			$p->setName($name);
			$p->setPassedByReference($param->byRef);

            $type = null;
			if (is_string($param->type)) {
				$type = $param->type;
			} else if ($param->type instanceof Name) {
                $type = implode('\\', $param->type->parts);
                $qualifiedType = TypeUtils::guessQualifiedName($this->struct, $type);
                if ($type !== $qualifiedType) {
                    $type = $qualifiedType;
                } else {
                    $type = '\\'.$type;
                }
            }

			if ($type) {
                $p->addType($type);
            }

			$this->parseValue($p, $param);

			$tag = $params->find($p, static function (ParamTag $t, $p) {
				return $t->getVariable() === '$' . $p->getName();
			});

			if ($tag !== null) {
			    $types = TypeUtils::expressionToTypes($tag->getType());
			    foreach ($types as $type) {
                    $p->addType(TypeUtils::guessQualifiedName($this->struct, $type));
                }
			    $p->setTypeDescription($tag->getDescription());
			}

			$m->addParameter($p);
		}
	}

	private function parseType(PhpMethod &$m, ClassMethod $node) {
		$returns = $m->getDocblock()->getTags('return');
		if ($returns->size() > 0) {
			$return = $returns->get(0);
			$m->addType($return->getType())->setTypeDescription($return->getDescription());
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
