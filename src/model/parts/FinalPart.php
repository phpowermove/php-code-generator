<?php
declare(strict_types=1);

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
	public function isFinal(): bool {
		return $this->final;
	}

	/**
	 * Sets this final
	 *
	 * @param bool $final `true` for final and `false` if not
	 * @return $this
	 */
	public function setFinal(bool $final) {
		$this->final = $final;

		return $this;
	}
}
