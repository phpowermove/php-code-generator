<?php
declare(strict_types=1);

namespace phpowermove\codegen\model\parts;

/**
 * Reference return part
 *
 * Keeps track whether the return value is a reference or not
 *
 * @author Thomas Gossmann
 */
trait ReferenceReturnPart {

	/** @var bool */
	private $referenceReturned = false;

	/**
	 * Set true if a reference is returned of false if not
	 *
	 * @param bool $referenceReturned
	 * @return $this
	 */
	public function setReferenceReturned(bool $referenceReturned) {
		$this->referenceReturned = $referenceReturned;

		return $this;
	}

	/**
	 * Returns whether a reference is returned
	 *
	 * @return bool
	 */
	public function isReferenceReturned(): bool {
		return $this->referenceReturned;
	}
}
