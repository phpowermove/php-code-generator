<?php
namespace gossi\codegen\model\parts;

use gossi\docblock\tags\AbstractTag;

trait TypeDocblockGeneratorTrait {

	/**
	 * Generates a type tag (return or var) but checks if one exists and updates this one
	 *
	 * @param AbstractTag $tag
	 */
	protected function generateTypeTag(AbstractTag $tag) {
		$docblock = $this->getDocblock();
		$type = $this->getType();

		if (!empty($type)) {

			// try to find tag at first and update
			$tags = $docblock->getTags($tag->getTagName());
			if ($tags->size() > 0) {
				$ttag = $tags->get(0);
				$ttag->setType($this->getType());
				$ttag->setDescription($this->getTypeDescription());
			}

			// ... anyway create and append
			else {
				$docblock->appendTag($tag
					->setType($this->getType())
					->setDescription($this->getTypeDescription())
				);
			}
		}
	}
}
