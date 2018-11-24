<?php
declare(strict_types=1);

namespace gossi\codegen\model;

/**
 * Interface to all php structs that can have constants
 *
 * Implementation is realized in the `ConstantsPart`
 *
 * @author Thomas Gossmann
 */
interface ConstantsInterface {

	/**
	 * Sets a collection of constants
	 *
	 * @param array|PhpConstant[] $constants
	 * @return $this
	 */
	public function setConstants(array $constants);

	/**
	 * Adds a constant
	 *
	 * @param string|PhpConstant $nameOrConstant constant or name
	 * @param string $value
	 * @return $this
	 */
	public function setConstant($nameOrConstant, string $value = null, bool $isExpression = false);

	/**
	 * Removes a constant
	 *
	 * @param string|PhpConstant $nameOrConstant $nameOrConstant constant or name
	 * @throws \InvalidArgumentException If the constant cannot be found
	 * @return $this
	 */
	public function removeConstant($nameOrConstant);

	/**
	 * Checks whether a constant exists
	 *
	 * @param string|PhpConstant $nameOrConstant
	 * @return bool
	 */
	public function hasConstant($nameOrConstant);

	/**
	 * Returns a constant
	 *
	 * @param string|PhpConstant $nameOrConstant constant or name
	 * @throws \InvalidArgumentException If the constant cannot be found
	 * @return PhpConstant
	 */
	public function getConstant($nameOrConstant);

	/**
	 * Returns constants
	 *
	 * @return PhpConstant[]
	 */
	public function getConstants();

	/**
	 * Returns all constant names
	 *
	 * @return string[]
	 */
	public function getConstantNames();

	/**
	 * Clears all constants
	 *
	 * @return $this
	 */
	public function clearConstants();
}
