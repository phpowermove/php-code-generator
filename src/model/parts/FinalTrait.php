<?php
namespace gossi\codegen\model\parts;

trait FinalTrait {

	private $final = false;

	/**
	 * Returns whether this is final
	 * 
	 * @return bool `true` for final and `false` if not
	 */
	public function isFinal() {
		return $this->final;
	}

	/**
	 * Sets this final
	 * 
	 * @param bool $bool `true` for final and `false` if not        	
	 * @return $this
	 */
	public function setFinal($bool) {
		$this->final = (boolean) $bool;

		return $this;
	}
}
