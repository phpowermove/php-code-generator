<?php
declare(strict_types=1);

namespace gossi\codegen\model\parts;

use gossi\codegen\model\PhpConstant;
use phootwork\collection\Map;
use phootwork\collection\Set;

/**
 * Constants part
 *
 * For all models that can contain constants
 *
 * @author Thomas Gossmann
 */
trait ConstantsPart {

	/** @var Map */
	private $constants;

	private function initConstants() {
		$this->constants = new Map();
	}

	/**
	 * Sets a collection of constants
	 *
	 * @param array|PhpConstant[] $constants
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

		$this->constants->setAll($normalizedConstants);

		return $this;
	}

	/**
	 * Adds a constant
	 *
	 * @param string|PhpConstant $nameOrConstant constant name or instance
	 * @param string $value
	 * @param bool $isExpression whether the value is an expression or not
	 * @return $this
	 */
	public function setConstant($nameOrConstant, string $value = null, bool $isExpression = false) {
		if ($nameOrConstant instanceof PhpConstant) {
			$name = $nameOrConstant->getName();
			$constant = $nameOrConstant;
		} else {
			$name = $nameOrConstant;
			$constant = new PhpConstant($nameOrConstant, $value, $isExpression);
		}

		$this->constants->set($name, $constant);

		return $this;
	}

	/**
	 * Removes a constant
	 *
	 * @param string|PhpConstant $nameOrConstant constant name
	 * @throws \InvalidArgumentException If the constant cannot be found
	 * @return $this
	 */
	public function removeConstant($nameOrConstant) {
		if ($nameOrConstant instanceof PhpConstant) {
			$nameOrConstant = $nameOrConstant->getName();
		}

		if (!$this->constants->has($nameOrConstant)) {
			throw new \InvalidArgumentException(sprintf('The constant "%s" does not exist.', $nameOrConstant));
		}

		$this->constants->remove($nameOrConstant);

		return $this;
	}

	/**
	 * Checks whether a constant exists
	 *
	 * @param string|PhpConstant $nameOrConstant
	 * @return bool
	 */
	public function hasConstant($nameOrConstant): bool {
		if ($nameOrConstant instanceof PhpConstant) {
			$nameOrConstant = $nameOrConstant->getName();
		}

		return $this->constants->has($nameOrConstant);
	}

	/**
	 * Returns a constant.
	 *
	 * @param string|PhpConstant $nameOrConstant
	 * @throws \InvalidArgumentException If the constant cannot be found
	 * @return PhpConstant
	 */
	public function getConstant($nameOrConstant): PhpConstant {
		if ($nameOrConstant instanceof PhpConstant) {
			$nameOrConstant = $nameOrConstant->getName();
		}

		if (!$this->constants->has($nameOrConstant)) {
			throw new \InvalidArgumentException(sprintf('The constant "%s" does not exist.', $nameOrConstant));
		}

		return $this->constants->get($nameOrConstant);
	}

	/**
	 * Returns all constants
	 *
	 * @return Map
	 */
	public function getConstants(): Map {
		return $this->constants;
	}

	/**
	 * Returns all constant names
	 *
	 * @return Set
	 */
	public function getConstantNames(): Set {
		return $this->constants->keys();
	}

	/**
	 * Clears all constants
	 *
	 * @return $this
	 */
	public function clearConstants() {
		$this->constants->clear();

		return $this;
	}
}
