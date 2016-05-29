<?php
namespace gossi\codegen\model\parts;

/**
 * Long description part
 *
 * For all models that can have an additional long description
 *
 * @author Thomas Gossmann
 */
trait LongDescriptionPart {

	/** @var string */
	private $longDescription;

	/**
	 * Returns the long description
	 *
	 * @return string
	 */
	public function getLongDescription() {
		return $this->longDescription;
	}

	/**
	 * Sets the long description
	 *
	 * @param string $longDescription
	 * @return $this
	 */
	public function setLongDescription($longDescription) {
		$this->longDescription = $longDescription;
		return $this;
	}
}
