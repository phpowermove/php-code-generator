<?php
namespace gossi\codegen\parser;

use PhpParser\PrettyPrinter\Standard;
use PhpParser\Node\Expr\Array_;

class PrettyPrinter extends Standard {
	
 /**
     * Pretty prints an array of nodes (statements) and indents them optionally.
     *
     * @param Node[] $nodes  Array of nodes
     * @param bool   $indent Whether to indent the printed nodes
     *
     * @return string Pretty printed statements
     */
    protected function pStmts(array $nodes, $indent = true) {
        $result = '';
	   $nodeBefore = NULL;
        foreach ($nodes as $node) {
            $comments = $node->getAttribute('comments', array());
            if ($comments) {
                $result .= "\n" . $this->pComments($comments);
                if ($node instanceof Stmt\Nop) {
                    continue;
                }
            }
		  
		  if ($nodeBefore && $nodeBefore->getLine() && $node->getLine()) {
			  $diff = $node->getLine()- $nodeBefore->getLine();
			  if ($diff > 0) {
				  $result .= str_repeat("\n", $diff - 1);
			  }
		  }
		  
            $result .= "\n" . $this->p($node) . ($node instanceof Expr ? ';' : '');
		  $nodeBefore = $node;
        }

	   if ($indent) {
            return preg_replace('~\n(?!$|' . $this->noIndentToken . ')~', "\n    ", $result);
        } else {
            return $result;
        }
    }
    
	public function pExpr_Array(Array_ $node) {
		return '[' . $this->pCommaSeparated($node->items) . ']';
	}
}