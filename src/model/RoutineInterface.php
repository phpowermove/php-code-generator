<?php
declare(strict_types=1);

namespace gossi\codegen\model;

interface RoutineInterface {

	/**
	 * Sets a collection of parameters
	 *
	 * Note: clears all parameters before setting the new ones
	 *
	 * @param PhpParameter[] $parameters
	 * @return $this
	 */
	public function setParameters(array $parameters);

	/**
	 * Adds a parameter
	 *
	 * @param PhpParameter $parameter
	 * @return $this
	 */
	public function addParameter(PhpParameter $parameter);

	/**
	 * Checks whether a parameter exists
	 *
	 * @param string $name parameter name
	 * @return bool `true` if a parameter exists and `false` if not
	 */
	public function hasParameter(string $name): bool;

	/**
	 * A quick way to add a parameter which is created from the given parameters
	 *
	 * @param string      $name
	 * @param null|string $type
	 * @param mixed       $defaultValue omit the argument to define no default value
	 *
	 * @return $this
	 */
	public function addSimpleParameter(string $name, string $type = null, $defaultValue = null);

	/**
	 * A quick way to add a parameter with description which is created from the given parameters
	 *
	 * @param string      $name
	 * @param null|string $type
	 * @param null|string $typeDescription
	 * @param mixed       $defaultValue omit the argument to define no default value
	 *
	 * @return $this
	 */
	public function addSimpleDescParameter(string $name, string $type = null, string $typeDescription = null, $defaultValue = null);

	/**
	 * Returns a parameter by index or name
	 *
	 * @param string|int $nameOrIndex
	 * @throws \InvalidArgumentException
	 * @return PhpParameter
	 */
	public function getParameter($nameOrIndex);

	/**
	 * Replaces a parameter at a given position
	 *
	 * @param int $position
	 * @param PhpParameter $parameter
	 * @throws \InvalidArgumentException
	 * @return $this
	 */
	public function replaceParameter(int $position, PhpParameter $parameter);

	/**
	 * Remove a parameter at a given position
	 *
	 * @param int|string|PhpParameter $param
	 * @return $this
	 */
	public function removeParameter($param);

	/**
	 * Returns a collection of parameters
	 *
	 * @return array
	 */
	public function getParameters();

	/**
	 * Set true if a reference is returned of false if not
	 *
	 * @param bool $referenceReturned
	 * @return $this
	 */
	public function setReferenceReturned(bool $referenceReturned);

	/**
	 * Returns whether a reference is returned
	 *
	 * @return bool
	 */
	public function isReferenceReturned(): bool;

	/**
	 * Sets the body for this
	 *
	 * @param string $body
	 * @return $this
	 */
	public function setBody(string $body);

	/**
	 * Returns the body
	 *
	 * @return string
	 */
	public function getBody(): string;

}
