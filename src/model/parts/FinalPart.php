<?php
namespace gossi\codegen\model\parts;

/**
 * Abstract Part
 *
 * Keeps track if the model has a final modifier or not
 *
 * @author Thomas Gossmann
 */
trait FinalPart {

	/** @var bool */
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
