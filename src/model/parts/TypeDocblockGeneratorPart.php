<?php
declare(strict_types=1);

namespace gossi\codegen\model\parts;

use gossi\codegen\model\PhpTypeInterface;
use gossi\codegen\utils\TypeUtils;
use gossi\docblock\Docblock;
use gossi\docblock\tags\AbstractTag;

/**
 * Type docblock generator part
 *
 * For all models that have a type and need docblock tag generated from it
 *
 * @author Thomas Gossmann
 */
trait TypeDocblockGeneratorPart {

	/**
	 * Returns the docblock
	 *
	 * @return Docblock
	 */
	abstract protected function getDocblock(): Docblock;

	/**
	 * Returns the type
	 *
	 * @return string[]|PhpTypeInterface[]
	 */
	abstract public function getTypes(): ?iterable;

	/**
	 * Returns the type description
	 *
	 * @return string
	 */
	abstract public function getTypeDescription(): ?string;

	/**
	 * Generates a type tag (return or var) but checks if one exists and updates this one
	 *
	 * @param AbstractTag $tag
	 */
	protected function generateTypeTag(AbstractTag $tag) {
		$docblock = $this->getDocblock();
		$types = $this->getTypes();

		if (!empty($types)) {

			// try to find tag at first and update
			$tags = $docblock->getTags($tag->getTagName());
			$type = TypeUtils::typesToExpression($this->getTypes());
			if ($tags->size() > 0) {
				$ttag = $tags->get(0);
				$ttag->setType($type);
				$ttag->setDescription($this->getTypeDescription());
			}

			// ... anyway create and append
			else {
				$docblock->appendTag($tag
					->setType($type)
					->setDescription($this->getTypeDescription())
				);
			}
		}
	}
}
