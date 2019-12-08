<?php
namespace gossi\codegen\parser\visitor\parts;

use gossi\codegen\model\AbstractPhpMember;
use gossi\codegen\model\PhpConstant;
use gossi\codegen\utils\TypeUtils;
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
                $types = TypeUtils::expressionToTypes($var->getType());
                foreach($types as $type) {
                    $type = TypeUtils::guessQualifiedName($this->struct, $type);
                    $member->addType($type);
                }
                $member->setTypeDescription($var->getDescription());
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
