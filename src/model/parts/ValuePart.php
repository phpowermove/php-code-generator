<?php
namespace gossi\codegen\model\parts;

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
	public function hasDefaultValue() {
		return $this->hasValue();
	}

	/**
	 * Sets the value
	 *
	 * @param mixed $value
	 * @return $this
	 */
	public function setValue($value) {
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
	 * @return mixed
	 */
	public function getValue() {
		return $this->value;
	}

	/**
	 * Checks whether a value or expression is set
	 *
	 * @return bool
	 */
	public function hasValue() {
		return $this->hasValue || $this->hasExpression;
	}

	/**
	 * Returns whether an expression is set
	 *
	 * @return bool
	 */
	public function isExpression() {
		return $this->hasExpression;
	}

	/**
	 * Sets an expression
	 *
	 * @param string $expr
	 * @return $this
	 */
	public function setExpression($expr) {
		$this->expression = $expr;
		$this->hasExpression = true;

		return $this;
	}

	/**
	 * Returns the expression
	 *
	 * @return string
	 */
	public function getExpression() {
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
