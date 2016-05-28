<?php
namespace gossi\codegen\model\parts;

trait ValueTrait {

	private $value;

	private $hasValue = false;

	private $expression;

	private $hasExpression = false;

	/**
	 * @param string $value
	 * @deprecated use `setValue()` instead
	 * @return static
	 */
	public function setDefaultValue($value) {
		return $this->setValue($value);
	}

	/**
	 * @deprecated use `unsetValue()` instead
	 */
	public function unsetDefaultValue() {
		return $this->unsetValue();
	}

	/**
	 * @deprecated use `getValue()` instead
	 */
	public function getDefaultValue() {
		return $this->getValue();
	}

	/**
	 * @deprecated use `hasValue()` instead
	 */
	public function hasDefaultValue() {
		return $this->hasValue();
	}

	public function setValue($value) {
		$this->value = $value;
		$this->hasValue = true;

		return $this;
	}

	public function unsetValue() {
		$this->value = null;
		$this->hasValue = false;

		return $this;
	}

	public function getValue() {
		return $this->value;
	}

	public function hasValue() {
		return $this->hasValue || $this->hasExpression;
	}

	public function isExpression() {
		return $this->hasExpression;
	}

	public function setExpression($expr) {
		$this->expression = $expr;
		$this->hasExpression = true;

		return $this;
	}

	public function getExpression() {
		return $this->expression;
	}

	public function unsetExpression() {
		$this->expression = null;
		$this->hasExpression = false;

		return $this;
	}
}