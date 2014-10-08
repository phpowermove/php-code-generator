<?php
namespace gossi\codegen\model;

interface ConstantsInterface {
	
	public function setConstants(array $constants);
	
	/**
	 *
	 * @param string|PhpConstant $name
	 * @param string $value
	 */
	public function setConstant($nameOrConstant, $value = null);
	
	/**
	 *
	 * @param string $name
	 *
	 * @return boolean
	 */
	public function hasConstant($name);

	/**
	 * Returns a constant.
	 *
	 * @param string $name
	 *
	 * @return PhpConstant
	 */
	public function getConstant($name);

	/**
	 *
	 * @param string $name
	 */
	public function removeConstant($name);

	public function getConstants($asObjects = false);
	
}
