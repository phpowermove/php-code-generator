<?php
namespace gossi\codegen\visitor;

use gossi\codegen\visitor\DefaultVisitor;
use gossi\codegen\model\DocblockInterface;
use gossi\docblock\Docblock;

class EmptyDocblockVisitor extends DefaultVisitor {
	
	protected function visitDocblock(Docblock $docblock) {
		$this->writeDocblock($docblock);
	}

}