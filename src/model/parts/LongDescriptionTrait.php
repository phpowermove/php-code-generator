<?php
namespace gossi\codegen\model\parts;

trait LongDescriptionTrait {

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
