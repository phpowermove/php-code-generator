<?php
declare(strict_types=1);

namespace gossi\codegen\model\parts;

/**
 * Name part
 *
 * For all models that do have a name
 *
 * @author Thomas Gossmann
 */
trait NamePart {

	/** @var string */
	private $name;

	/**
	 * Sets the name
	 *
	 * @param string $name
	 * @return $this
	 */
	public function setName(string $name = null) {
		$this->name = $name;

		return $this;
	}

	/**
	 * Returns the name
	 *
	 * @return string
	 */
	public function getName(): ?string {
		return $this->name;
	}
}
