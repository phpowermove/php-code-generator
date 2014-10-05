<?php
namespace gossi\codegen\model\parts;

trait FinalTrait {

	private $final = false;

	public function isFinal() {
		return $this->final;
	}

	/**
	 *
	 * @param boolean $bool        	
	 * @return $this
	 */
	public function setFinal($bool) {
		$this->final = (boolean) $bool;
		
		return $this;
	}
}