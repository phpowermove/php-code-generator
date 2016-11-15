<?php
namespace gossi\codegen\model\parts;

use gossi\codegen\model\PhpProperty;
use phootwork\collection\Map;

/**
 * Properties part
 *
 * For all models that can have properties
 *
 * @author Thomas Gossmann
 */
trait PropertiesPart {

	/** @var Map */
	private $properties;
	
	private function initProperties() {
		$this->properties = new Map();
	}

	/**
	 * Sets a collection of properties
	 *
	 * @param PhpProperty[] $properties
	 * @return $this
	 */
	public function setProperties(array $properties) {
		foreach ($this->properties as $prop) {
			$prop->setParent(null);
		}

		$this->properties->clear();

		foreach ($properties as $prop) {
			$this->setProperty($prop);
		}

		return $this;
	}

	/**
	 * Adds a property
	 *
	 * @param PhpProperty $property
	 * @return $this
	 */
	public function setProperty(PhpProperty $property) {
		$property->setParent($this);
		$this->properties->set($property->getName(), $property);

		return $this;
	}

	/**
	 * Removes a property
	 *
	 * @param PhpProperty|string $nameOrProperty property name or instance
	 * @throws \InvalidArgumentException If the property cannot be found
	 * @return $this
	 */
	public function removeProperty($nameOrProperty) {
		if ($nameOrProperty instanceof PhpProperty) {
			$nameOrProperty = $nameOrProperty->getName();
		}

		if (!$this->properties->has($nameOrProperty)) {
			throw new \InvalidArgumentException(sprintf('The property "%s" does not exist.', $nameOrProperty));
		}
		$p = $this->properties->get($nameOrProperty);
		$p->setParent(null);
		$this->properties->remove($nameOrProperty);

		return $this;
	}

	/**
	 * Checks whether a property exists
	 *
	 * @param PhpProperty|string $nameOrProperty property name or instance
	 * @return bool `true` if a property exists and `false` if not
	 */
	public function hasProperty($nameOrProperty) {
		if ($nameOrProperty instanceof PhpProperty) {
			$nameOrProperty = $nameOrProperty->getName();
		}

		return $this->properties->has($nameOrProperty);
	}

	/**
	 * Returns a property
	 *
	 * @param string $nameOrProperty property name
	 * @throws \InvalidArgumentException If the property cannot be found
	 * @return PhpProperty
	 */
	public function getProperty($nameOrProperty) {
		if ($nameOrProperty instanceof PhpProperty) {
			$nameOrProperty = $nameOrProperty->getName();
		}

		if (!$this->properties->has($nameOrProperty)) {
			throw new \InvalidArgumentException(sprintf('The property "%s" does not exist.', $nameOrProperty));
		}

		return $this->properties->get($nameOrProperty);
	}

	/**
	 * Returns a collection of properties
	 *
	 * @return Map
	 */
	public function getProperties() {
		return $this->properties;
	}

	/**
	 * Returns all property names
	 *
	 * @return Set
	 */
	public function getPropertyNames() {
		return $this->properties->keys();
	}

	/**
	 * Clears all properties
	 *
	 * @return $this
	 */
	public function clearProperties() {
		foreach ($this->properties as $property) {
			$property->setParent(null);
		}
		$this->properties->clear();

		return $this;
	}
}
