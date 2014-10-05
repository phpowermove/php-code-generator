<?php
namespace gossi\codegen\model\parts;

trait LongDescriptionTrait {

	private $longDescription;

	/**
	 *
	 * @return string
	 */
	public function getLongDescription() {
		return $this->longDescription;
	}

	/**
	 *
	 * @param string $longDescription        	
	 */
	public function setLongDescription($longDescription) {
		$this->longDescription = $longDescription;
		return $this;
	}
}