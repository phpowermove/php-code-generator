<?php
namespace gossi\codegen\model\parts;

use gossi\docblock\Docblock;

/**
 * Docblock Part
 *
 * Setting and getting a docblock on a model
 *
 * @author Thomas Gossmann
 */
trait DocblockPart {

	/** @var Docblock */
	private $docblock;

	/**
	 * Sets the docblock
	 *
	 * @param Docblock|string $doc
	 * @return $this
	 */
	public function setDocblock($doc) {
		if (is_string($doc)) {
			$doc = trim($doc);
			$doc = new Docblock($doc);
		}
		$this->docblock = $doc;

		return $this;
	}

	/**
	 * Returns the docblock
	 *
	 * @return Docblock
	 */
	public function getDocblock() {
		return $this->docblock;
	}

}
