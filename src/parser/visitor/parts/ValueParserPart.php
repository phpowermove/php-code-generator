<?php
namespace gossi\codegen\parser\visitor\parts;

use gossi\codegen\model\ValueInterface;
use gossi\codegen\parser\PrettyPrinter;
use PhpParser\Node;
use PhpParser\Node\Const_;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\ConstFetch;
use PhpParser\Node\Scalar\DNumber;
use PhpParser\Node\Scalar\LNumber;
use PhpParser\Node\Scalar\MagicConst;
use PhpParser\Node\Scalar\String_;

trait ValueParserPart {
	
	private $constMap = [
		'false' => false,
		'true' => true
	];
	
	private function parseValue(ValueInterface $obj, Node $node) {
		$value = $node instanceof Const_ ? $node->value : $node->default;
		if ($value !== null) {
			if ($this->isPrimitive($value)) {
				$obj->setValue($this->getPrimitiveValue($value));
			} else {
				$obj->setExpression($this->getExpression($value));
			}
		}
	}
	
	private function isPrimitive(Node $node) {
		return $node instanceof String_
			|| $node instanceof LNumber
			|| $node instanceof DNumber
			|| $this->isBool($node)
			|| $this->isNull($node);
	}
	
	private function getPrimitiveValue(Node $node) {
		if ($this->isBool($node)) {
			return (bool) $this->getExpression($node);
		}
	
		if ($this->isNull($node)) {
			return null;
		}
	
		return $node->value;
	}
	
	private function isBool(Node $node) {
		if ($node instanceof ConstFetch) {
			$const = $node->name->parts[0];
			if (isset($this->constMap[$const])) {
				return is_bool($this->constMap[$const]);
			}
	
			return is_bool($const);
		}
	}
	
	private function isNull(Node $node) {
		if ($node instanceof ConstFetch) {
			$const = $node->name->parts[0];
			return $const === 'null';
		}
	}
	
	/**
	 * Returns the value from a node
	 *
	 * @param Node $node
	 * @return mixed
	 */
	private function getExpression(Node $node) {
		if ($node instanceof ConstFetch) {
			$const = $node->name->parts[0];
			if (isset($this->constMap[$const])) {
				return $this->constMap[$const];
			}
	
			return $const;
		}
		
		if ($node instanceof ClassConstFetch) {
			return $node->class->parts[0] . '::' . $node->name;
		}
	
		if ($node instanceof MagicConst) {
			return $node->getName();
		}
		
		if ($node instanceof Array_) {
			$prettyPrinter = new PrettyPrinter();
			return $prettyPrinter->prettyPrintExpr($node);
		}
	}
}