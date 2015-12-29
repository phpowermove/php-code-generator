<?php
namespace gossi\codegen\model\parts;

use gossi\codegen\model\PhpConstant;

trait ConstantsTrait {

	/**
	 * @var PhpConstant[]
	 */
	private $constants = [];

	/**
	 * Sets a collection of constants
	 *
	 * @param PhpConstant[] $constants
	 */
	public function setConstants(array $constants) {
		$normalizedConstants = array();
		foreach ($constants as $name => $value) {
			if (!$value instanceof PhpConstant) {
				$constValue = $value;
				$value = new PhpConstant($name);
				$value->setValue($constValue);
			}
			
			$normalizedConstants[$name] = $value;
		}
		
		$this->constants = $normalizedConstants;
		
		return $this;
	}

	/**
	 * Adds a constant
	 *
	 * @param string|PhpConstant $name constant name or instance
	 * @param string $value
	 * @return $this
	 */
	public function setConstant($nameOrConstant, $value = null) {
		if ($nameOrConstant instanceof PhpConstant) {
			$name = $nameOrConstant->getName();
			$constant = $nameOrConstant;
		} else {
			$name = $nameOrConstant;
			$constant = new PhpConstant($nameOrConstant);
			$constant->setValue($value);
		}
		
		$this->constants[$name] = $constant;
		
		return $this;
	}

	/**
	 * Checks whether a constant exists
	 *
	 * @param string $name
	 * @return boolean
	 */
	public function hasConstant($name) {
		return array_key_exists($name, $this->constants);
	}

	/**
	 * Returns a constant.
	 *
	 * @param string $name constant name
	 *
	 * @return PhpConstant
	 */
	public function getConstant($name) {
		if (!isset($this->constants[$name])) {
			throw new \InvalidArgumentException(sprintf('The constant "%s" does not exist.', $name));
		}
		
		return $this->constants[$name];
	}

	/**
	 * Removes a constant
	 *
	 * @param string $name constant name
	 * @return $this
	 */
	public function removeConstant($name) {
		if (!array_key_exists($name, $this->constants)) {
			throw new \InvalidArgumentException(sprintf('The constant "%s" does not exist.', $name));
		}
		
		unset($this->constants[$name]);
		
		return $this;
	}

	/**
	 * Returns constants
	 *
	 * @param boolean $asObjects (deprecated, will be replaced with getConstantNames() and getConstant???() [??? = e.g. Map, Array] method)
	 */
	public function getConstants($asObjects = false) {
		if ($asObjects) {
			return $this->constants;
		}
		
		return array_map(function (PhpConstant $constant) {
			return $constant->getValue();
		}, $this->constants);
	}
}