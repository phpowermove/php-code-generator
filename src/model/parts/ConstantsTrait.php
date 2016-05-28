<?php
namespace gossi\codegen\model\parts;

use gossi\codegen\model\PhpConstant;

trait ConstantsTrait {

	/** @var PhpConstant[] */
	private $constants = [];

	/**
	 * Sets a collection of constants
	 *
	 * @param PhpConstant[] $constants
	 * @return $this
	 */
	public function setConstants(array $constants) {
		$normalizedConstants = [];
		foreach ($constants as $name => $value) {
			if ($value instanceof PhpConstant) {
				$name = $value->getName();
			} else {
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
	 * @param string|PhpConstant $nameOrConstant constant name or instance
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
	 * Removes a constant
	 *
	 * @param string $nameOrConstant constant name
	 * @throws \InvalidArgumentException If the constant cannot be found
	 * @return $this
	 */
	public function removeConstant($nameOrConstant) {
		if ($nameOrConstant instanceof PhpConstant) {
			$nameOrConstant = $nameOrConstant->getName();
		}

		if (!array_key_exists($nameOrConstant, $this->constants)) {
			throw new \InvalidArgumentException(sprintf('The constant "%s" does not exist.', $nameOrConstant));
		}

		unset($this->constants[$nameOrConstant]);

		return $this;
	}

	/**
	 * Checks whether a constant exists
	 *
	 * @param string|PhpConstant $nameOrConstant
	 * @return boolean
	 */
	public function hasConstant($nameOrConstant) {
		if ($nameOrConstant instanceof PhpConstant) {
			$nameOrConstant = $nameOrConstant->getName();
		}
		return array_key_exists($nameOrConstant, $this->constants);
	}

	/**
	 * Returns a constant.
	 *
	 * @param string|PhpConstant $nameOrConstant
	 * @throws \InvalidArgumentException If the constant cannot be found
	 * @return PhpConstant
	 */
	public function getConstant($nameOrConstant) {
		if ($nameOrConstant instanceof PhpConstant) {
			$nameOrConstant = $nameOrConstant->getName();
		}

		if (!isset($this->constants[$nameOrConstant])) {
			throw new \InvalidArgumentException(sprintf('The constant "%s" does not exist.', $nameOrConstant));
		}

		return $this->constants[$nameOrConstant];
	}

	/**
	 * Returns all constants
	 *
	 * @return PhpConstant[]
	 */
	public function getConstants() {
		return $this->constants;
	}

	/**
	 * Returns all constant names
	 * 
	 * @return string[]
	 */
	public function getConstantNames() {
		return array_keys($this->constants);
	}

	/**
	 * Clears all constants
	 * 
	 * @return $this
	 */
	public function clearConstants() {
		$this->constants = [];

		return $this;
	}
}