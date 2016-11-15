<?php
namespace gossi\codegen\parser;

use PhpParser\PrettyPrinter\Standard;
use PhpParser\Node\Expr\Array_;

class PrettyPrinter extends Standard {
	
	public function pExpr_Array(Array_ $node) {
		return '[' . $this->pCommaSeparated($node->items) . ']';
	}
}