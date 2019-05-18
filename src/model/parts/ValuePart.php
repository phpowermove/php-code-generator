<?php
declare(strict_types=1);

namespace gossi\codegen\model\parts;

use gossi\codegen\model\PhpConstant;

/**
 * Value part
 *
 * For all models that have a value (or expression)
 *
 * @author Thomas Gossmann
 */
trait ValuePart {

	/** @var mixed */
	private $value;

	/** @var bool */
	private $hasValue = false;

	/** @var string */
	private $expression;

	/** @var bool */
	private $hasExpression = false;

	/**
	 * @deprecated use `setValue()` instead
	 * @param mixed $value
	 * @return $this
	 */
	public function setDefaultValue($value) {
		return $this->setValue($value);
	}

	/**
	 * @deprecated use `unsetValue()` instead
	 * @return $this
	 */
	public function unsetDefaultValue() {
		return $this->unsetValue();
	}

	/**
	 * @deprecated use `getValue()` instead
	 * @return mixed
	 */
	public function getDefaultValue() {
		return $this->getValue();
	}

	/**
	 * @deprecated use `hasValue()` instead
	 * @return bool
	 */
	public function hasDefaultValue(): bool {
		return $this->hasValue();
	}

	/**
	 * Returns whether the given value is a primitive
	 *
	 * @param mixed $value
	 * @return bool
	 */
	private function isPrimitive($value): bool {
		return (is_string($value)
			|| is_int($value)
			|| is_float($value)
			|| is_bool($value)
			|| is_null($value)
			|| ($value instanceof PhpConstant));
	}

	/**
	 * Sets the value
	 *
	 * @param string|int|float|bool|null|PhpConstant $value
	 * @throws \InvalidArgumentException if the value is not an accepted primitve
	 * @return $this
	 */
	public function setValue($value) {
		if (!$this->isPrimitive($value)) {
			throw new \InvalidArgumentException('Use setValue() only for primitives and PhpConstant, anyway use setExpression() instead.');
		}
		$this->value = $value;
		$this->hasValue = true;

		return $this;
	}

	/**
	 * Unsets the value
	 *
	 * @return $this
	 */
	public function unsetValue() {
		$this->value = null;
		$this->hasValue = false;

		return $this;
	}

	/**
	 * Returns the value
	 *
	 * @return string|int|float|bool|null|PhpConstant
	 */
	public function getValue() {
		return $this->value;
	}

	/**
	 * Checks whether a value or expression is set
	 *
	 * @return bool
	 */
	public function hasValue(): bool {
		return $this->hasValue || $this->hasExpression;
	}

	/**
	 * Returns whether an expression is set
	 *
	 * @return bool
	 */
	public function isExpression(): bool {
		return $this->hasExpression;
	}

	/**
	 * Sets an expression
	 *
	 * @param string $expr
	 * @return $this
	 */
	public function setExpression(string $expr) {
		$this->expression = $expr;
		$this->hasExpression = true;

		return $this;
	}

	/**
	 * Returns the expression
	 *
	 * @return string
	 */
	public function getExpression(): ?string {
		return $this->expression;
	}

	/**
	 * Unsets the expression
	 *
	 * @return $this
	 */
	public function unsetExpression() {
		$this->expression = null;
		$this->hasExpression = false;

		return $this;
	}
}
