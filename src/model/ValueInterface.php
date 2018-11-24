<?php
declare(strict_types=1);

namespace gossi\codegen\model;

interface ValueInterface {

	/**
	 * Sets the value
	 *
	 * @param mixed $value
	 * @return $this
	 */
	public function setValue($value);

	/**
	 * Unsets the value
	 *
	 * @return $this
	 */
	public function unsetValue();

	/**
	 * Returns the value
	 *
	 * @return mixed
	 */
	public function getValue();

	/**
	 * Checks whether a value or expression is set
	 *
	 * @return bool
	 */
	public function hasValue(): bool;

	/**
	 * Returns whether an expression is set
	 *
	 * @return bool
	 */
	public function isExpression(): bool;

	/**
	 * Sets an expression
	 *
	 * @param string $expr
	 * @return $this
	 */
	public function setExpression(string $expr);

	/**
	 * Returns the expression
	 *
	 * @return string
	 */
	public function getExpression(): ?string;

	/**
	 * Unsets the expression
	 *
	 * @return $this
	 */
	public function unsetExpression();
}