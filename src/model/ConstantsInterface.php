<?php
namespace gossi\codegen\model;

interface ConstantsInterface {
	
	/**
	 * Sets a collection of constants
	 * 
	 * @param PhpConstant[] $constants
	 */
	public function setConstants(array $constants);
	
	/**
	 * Adds a constant
	 * 
	 * @param string|PhpConstant $name constant name or instance
	 * @param string $value
	 * @return $this
	 */
	public function setConstant($nameOrConstant, $value = null);
	
	/**
	 * Checks whether a constant exists
	 * 
	 * @param string $name
	 * @return boolean
	 */
	public function hasConstant($name);

	/**
	 * Returns a constant.
	 *
	 * @param string $name constant name
	 *
	 * @return PhpConstant
	 */
	public function getConstant($name);

	/**
	 * Removes a constant
	 * 
	 * @param string $name constant name
	 * @return $this
	 */
	public function removeConstant($name);

	/**
	 * Returns constants
	 * 
	 * @param boolean $asObjects (deprecated, will be replaced with getConstantNames() method)
	 */
	public function getConstants($asObjects = false);
	
}
