<?php
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
