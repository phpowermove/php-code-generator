<?php declare(strict_types=1);
/*
 * This file is part of the php-code-generator package.
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 *  @license Apache-2.0
 */

namespace gossi\codegen\parser\visitor\parts;

use gossi\codegen\model\AbstractPhpMember;
use gossi\codegen\model\PhpConstant;
use PhpParser\Comment\Doc;
use PhpParser\Node;

trait MemberParserPart {

	/**
	 *
	 * @param AbstractPhpMember|PhpConstant $member
	 * @param Doc|null $doc
	 */
	private function parseMemberDocblock(AbstractPhpMember|PhpConstant $member, ?Doc $doc = null) {
		if ($doc !== null) {
			$member->setDocblock($doc->getReformattedText());
			$docblock = $member->getDocblock();
			$member->setDescription($docblock->getShortDescription());
			$member->setLongDescription($docblock->getLongDescription());
		}
	}

	/**
	 * Returns the visibility from a node
	 *
	 * @param Node $node
	 *
	 * @return string
	 */
	private function getVisibility(Node $node): string {
		return match (true) {
			$node->isPrivate() => AbstractPhpMember::VISIBILITY_PRIVATE,
			$node->isProtected() => AbstractPhpMember::VISIBILITY_PROTECTED,
			default => AbstractPhpMember::VISIBILITY_PUBLIC
		};
	}
}
