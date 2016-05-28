<?php
namespace gossi\codegen\model\parts;

trait AbstractTrait {

	private $abstract = false;

	/**
	 * Returns whether this is abstract
	 * 
	 * @return boolean `true` for abstract and `false` if not
	 */
	public function isAbstract() {
		return $this->abstract;
	}

	/**
	 * Sets this to abstract
	 * 
	 * @param boolean $bool `true` for abstract and `false` if not
	 * @return $this        	
	 */
	public function setAbstract($bool) {
		$this->abstract = (boolean) $bool;

		return $this;
	}
}