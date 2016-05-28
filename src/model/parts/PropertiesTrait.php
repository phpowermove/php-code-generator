<?php
namespace gossi\codegen\model\parts;

use gossi\codegen\model\PhpProperty;

trait PropertiesTrait {

	/** @var PhpProperty[] */
	private $properties = [];

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

		$this->properties = [];

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
		$this->properties[$property->getName()] = $property;

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

		if (!array_key_exists($nameOrProperty, $this->properties)) {
			throw new \InvalidArgumentException(sprintf('The property "%s" does not exist.', $nameOrProperty));
		}
		$p = $this->properties[$nameOrProperty];
		$p->setParent(null);
		unset($this->properties[$nameOrProperty]);

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

		return isset($this->properties[$nameOrProperty]);
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

		if (!array_key_exists($nameOrProperty, $this->properties)) {
			throw new \InvalidArgumentException(sprintf('The property "%s" does not exist.', $nameOrProperty));
		}

		return $this->properties[$nameOrProperty];
	}

	/**
	 * Returns a collection of properties
	 * 
	 * @return PhpProperty[]
	 */
	public function getProperties() {
		return $this->properties;
	}

	/**
	 * Returns all property names
	 * 
	 * @return string[]
	 */
	public function getPropertyNames() {
		return array_keys($this->properties);
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
		$this->properties = [];

		return $this;
	}
}
