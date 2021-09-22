<?php
namespace phpowermove\codegen\parser\visitor\parts;

use phpowermove\codegen\model\AbstractPhpMember;
use phpowermove\codegen\model\PhpConstant;
use PhpParser\Comment\Doc;
use PhpParser\Node;

trait MemberParserPart {

	/**
	 *
	 * @param AbstractPhpMember|PhpConstant $member
	 * @param Doc $doc
	 */
	private function parseMemberDocblock(&$member, Doc $doc = null) {
		if ($doc !== null) {
			$member->setDocblock($doc->getReformattedText());
			$docblock = $member->getDocblock();
			$member->setDescription($docblock->getShortDescription());
			$member->setLongDescription($docblock->getLongDescription());

			$vars = $docblock->getTags('var');
			if ($vars->size() > 0) {
				$var = $vars->get(0);
				$member->setType($var->getType(), $var->getDescription());
			}
		}
	}

	/**
	 * Returns the visibility from a node
	 *
	 * @param Node $node
	 * @return string
	 */
	private function getVisibility(Node $node) {
		if ($node->isPrivate()) {
			return AbstractPhpMember::VISIBILITY_PRIVATE;
		}

		if ($node->isProtected()) {
			return AbstractPhpMember::VISIBILITY_PROTECTED;
		}

		return AbstractPhpMember::VISIBILITY_PUBLIC;
	}
}
