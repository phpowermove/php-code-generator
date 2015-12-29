<?php
namespace gossi\codegen\model\parts;

use gossi\codegen\model\PhpProperty;

trait PropertiesTrait {

	/**
	 *
	 * @var PhpProperty[]
	 */
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
	 * Returns a property
	 * 
	 * @param string $property property name
	 * @return PhpProperty        	
	 */
	public function getProperty($property) {
		if ($property instanceof PhpProperty) {
			$property = $property->getName();
		}
		
		if (isset($this->properties[$property])) {
			return $this->properties[$property];
		}
	}

	/**
	 * Checks whether a property exists
	 * 
	 * @param PhpProperty|string $property property name or instance
	 * @return boolean `true` if a property exists and `false` if not        	
	 */
	public function hasProperty($property) {
		if ($property instanceof PhpProperty) {
			$property = $property->getName();
		}
		
		return isset($this->properties[$property]);
	}

	/**
	 * Removes a property
	 * 
	 * @param PhpProperty|string $property property name or instance
	 * @return $this         	
	 */
	public function removeProperty($property) {
		if ($property instanceof PhpProperty) {
			$property = $property->getName();
		}
		
		if (!array_key_exists($property, $this->properties)) {
			throw new \InvalidArgumentException(sprintf('The property "%s" does not exist.', $property));
		}
		$p = $this->properties[$property];
		$p->setParent(null);
		unset($this->properties[$property]);
		
		return $this;
	}

	/**
	 * Returns a collection of properties
	 * 
	 * @return PhpProperty[]
	 */
	public function getProperties() {
		return $this->properties;
	}
}