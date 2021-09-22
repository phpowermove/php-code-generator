<?php
declare(strict_types=1);

namespace phpowermove\codegen\model\parts;

/**
 * Abstract Part
 *
 * Keeps track if the model has an abstract modifier or not
 *
 * @author Thomas Gossmann
 */
trait AbstractPart {

	/** @var bool */
	private $abstract = false;

	/**
	 * Returns whether this is abstract
	 *
	 * @return bool `true` for abstract and `false` if not
	 */
	public function isAbstract(): bool {
		return $this->abstract;
	}

	/**
	 * Sets this to abstract
	 *
	 * @param bool $abstract `true` for abstract and `false` if not
	 * @return $this
	 */
	public function setAbstract(bool $abstract) {
		$this->abstract = $abstract;

		return $this;
	}
}
