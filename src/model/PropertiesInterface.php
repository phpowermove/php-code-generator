<?php
declare(strict_types=1);

namespace phpowermove\codegen\model;

use phootwork\collection\Map;
use phootwork\collection\Set;

interface PropertiesInterface {

	/**
	 * Sets a collection of properties
	 *
	 * @param PhpProperty[] $properties
	 * @return $this
	 */
	public function setProperties(array $properties);

	/**
	 * Adds a property
	 *
	 * @param PhpProperty $property
	 * @return $this
	 */
	public function setProperty(PhpProperty $property);

	/**
	 * Removes a property
	 *
	 * @param PhpProperty|string $nameOrProperty property name or instance
	 * @throws \InvalidArgumentException If the property cannot be found
	 * @return $this
	 */
	public function removeProperty($nameOrProperty);

	/**
	 * Checks whether a property exists
	 *
	 * @param PhpProperty|string $nameOrProperty property name or instance
	 * @return bool `true` if a property exists and `false` if not
	 */
	public function hasProperty($nameOrProperty): bool;

	/**
	 * Returns a property
	 *
	 * @param string $nameOrProperty property name
	 * @throws \InvalidArgumentException If the property cannot be found
	 * @return PhpProperty
	 */
	public function getProperty($nameOrProperty): PhpProperty;

	/**
	 * Returns a collection of properties
	 *
	 * @return Map
	 */
	public function getProperties(): Map;

	/**
	 * Returns all property names
	 *
	 * @return Set
	 */
	public function getPropertyNames(): Set;

	/**
	 * Clears all properties
	 *
	 * @return $this
	 */
	public function clearProperties();
}
