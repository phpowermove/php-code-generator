<?php
namespace gossi\codegen\model\parts;

trait NameTrait {

	private $name;

	/**
	 * Sets the name
	 * 
	 * @param string $name        	
	 * @return $this
	 */
	public function setName($name) {
		$this->name = $name;

		return $this;
	}

	/**
	 * Returns the name
	 * 
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}
}