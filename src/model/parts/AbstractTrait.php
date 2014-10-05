<?php
namespace gossi\codegen\model\parts;

trait AbstractTrait {

	private $abstract = false;

	public function isAbstract() {
		return $this->abstract;
	}

	/**
	 *
	 * @param boolean $bool        	
	 */
	public function setAbstract($bool) {
		$this->abstract = (boolean) $bool;
		
		return $this;
	}
}