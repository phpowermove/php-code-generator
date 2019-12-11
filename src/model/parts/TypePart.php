<?php
declare(strict_types=1);

namespace gossi\codegen\model\parts;

use gossi\codegen\model\PhpType;
use gossi\codegen\model\PhpTypeInterface;
use gossi\codegen\utils\TypeUtils;
use phootwork\collection\Map;

/**
 * Type part
 *
 * For all models that have a type
 *
 * @author Thomas Gossmmann
 */
trait TypePart {

	/** @var null|Map|string[]|PhpTypeInterface[] */
	private $types;

	/** @var null|string */
	private $typeDescription;

	/** @var bool */
	private $typeNullable = false;

	public function initTypes(): void {
	    $this->types = new Map();
    }

	/**
	 * Sets the type
	 *
	 * @param null|Map|string[]|PhpTypeInterface[] $types
	 * @param string $description
	 *
	 * @return $this
	 */
    public function setTypes(?iterable $types) {
        if (!$types) {
            return $this;
        }
        $this->types->clear();
        foreach ($types as $type) {
            $this->addType($type);
        }

        return $this;
	}

	/**
	 * adds a type
	 *
	 * @param string|PhpTypeInterface $type
	 * @param string $description
	 * @return $this
	 */
	public function addType($type) {
	    if ($type === 'null') {
	        $this->setNullable(true);
	        return $this;
        }
	    if ($type) {
	        if (!$type instanceof PhpTypeInterface) {
                if (substr($type, -2, 2) === '[]') {
                    $this->addType('iterable');
                }
	            $type = new PhpType($type);
            }

            $this->types->set($type->getQualifiedName(), $type);
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
	    if (!$description) {
	        return $this;
        }
		$this->typeDescription = $description;
		return $this;
	}

	/**
	 * Returns the type
	 *
	 * @return PhpTypeInterface[]|Map
	 */
	public function getTypes(): ?iterable {
		return $this->types;
	}

	public function getTypeExpression(): ?string {
	    return TypeUtils::typesToExpression($this->types);
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
