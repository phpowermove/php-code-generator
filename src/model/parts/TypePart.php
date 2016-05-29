<?php
namespace gossi\codegen\model\parts;

/**
 * Type part
 *
 * For all models that have a type
 *
 * @author Thomas Gossmmann
 */
trait TypePart {

	/** @var string */
	private $type;

	/** @var string */
	private $typeDescription;

	/**
	 * Sets the type
	 *
	 * @param string $type
	 * @param string $description
	 * @return $this
	 */
	public function setType($type, $description = null) {
		$this->type = $type;
		if (null !== $description) {
			$this->setTypeDescription($description);
		}

		return $this;
	}

	/**
	 * Sets the description for the type
	 *
	 * @param string $description
	 * @return $this
	 */
	public function setTypeDescription($description) {
		$this->typeDescription = $description;
		return $this;
	}

	/**
	 * Returns the type
	 *
	 * @return string
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * Returns the type description
	 *
	 * @return string
	 */
	public function getTypeDescription() {
		return $this->typeDescription;
	}
}
