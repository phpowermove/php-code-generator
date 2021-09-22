<?php
namespace phpowermove\codegen\parser;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Stmt;
use PhpParser\PrettyPrinter\Standard;

class PrettyPrinter extends Standard {

    /**
     * Pretty prints an array of nodes (statements) and indents them optionally.
     *
     * @param Node[] $nodes  Array of nodes
     * @param bool   $indent Whether to indent the printed nodes
     *
     * @return string Pretty printed statements
     */
    protected function pStmts(array $nodes, bool $indent = true): string {
        $result = '';
		$prevNode = null;

        foreach ($nodes as $node) {
            $comments = $node->getAttribute('comments', []);
            if ($comments) {
                $result .= "\n" . $this->pComments($comments);
                if ($node instanceof Stmt\Nop) {
                    continue;
                }
            }

		  if ($prevNode && $prevNode->getLine() && $node->getLine()) {
			  $diff = $node->getLine()- $prevNode->getLine();
			  if ($diff > 0) {
				  $result .= str_repeat("\n", $diff - 1);
			  }
		  }

          $result .= "\n" . $this->p($node) . ($node instanceof Expr ? ';' : '');
		  $prevNode = $node;
        }

	   if ($indent) {
            return preg_replace('~\n(?!$)~', "\n    ", $result);
        } else {
            return $result;
        }
    }

	public function pExpr_Array(Array_ $node) {
		return '[' . $this->pCommaSeparated($node->items) . ']';
	}
}
