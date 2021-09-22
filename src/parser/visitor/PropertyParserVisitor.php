<?php
declare(strict_types=1);

namespace phpowermove\codegen\parser\visitor;

use phpowermove\codegen\model\PhpProperty;
use phpowermove\codegen\parser\visitor\parts\MemberParserPart;
use phpowermove\codegen\parser\visitor\parts\ValueParserPart;
use PhpParser\Node\Stmt\Property;

class PropertyParserVisitor extends StructParserVisitor {

	use ValueParserPart;
	use MemberParserPart;

	public function visitProperty(Property $node) {
		$prop = $node->props[0];

		$p = new PhpProperty($prop->name->name);
		$p->setStatic($node->isStatic());
		$p->setVisibility($this->getVisibility($node));

		$this->parseValue($p, $prop);
		$this->parseMemberDocblock($p, $node->getDocComment());

		$this->struct->setProperty($p);
	}

}
