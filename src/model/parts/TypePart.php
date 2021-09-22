<?php
declare(strict_types=1);

namespace phpowermove\codegen\model\parts;

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

	/** @var bool */
	private $typeNullable;

	/**
	 * Sets the type
	 *
	 * @param string $type
	 * @param string $description
	 * @return $this
	 */
	public function setType(?string $type, string $description = null) {
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
	public function setTypeDescription(string $description) {
		$this->typeDescription = $description;
		return $this;
	}

	/**
	 * Returns the type
	 *
	 * @return string
	 */
	public function getType(): ?string {
		return $this->type;
	}

	/**
	 * Returns the type description
	 *
	 * @return string
	 */
	public function getTypeDescription(): ?string {
		return $this->typeDescription;
	}

	/**
	 * Returns whether the type is nullable
	 * 
	 * @return bool
	 */
	public function getNullable(): bool {
		return $this->typeNullable;
	}

	/**
	 * Sets the type nullable
	 * 
	 * @param bool $nullable
	 * @return $this
	 */
	public function setNullable(bool $nullable) {
		$this->typeNullable = $nullable;
		return $this;
	}
}
