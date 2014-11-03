<?php
namespace gossi\codegen\model\parts;

use gossi\codegen\model\PhpParameter;

trait ParametersTrait {

	/**
	 *
	 * @var PhpParameter[]
	 */
	private $parameters = [];

	public function setParameters(array $parameters) {
		$this->parameters = array_values($parameters);

		return $this;
	}

	public function addParameter(PhpParameter $parameter) {
		$this->parameters[count($this->parameters)] = $parameter;

		return $this;
	}

	/**
	 * @param string      $name
	 * @param null|string $type
	 * @param mixed       $defaultValue omit the argument to define now default value
	 *
	 * @return $this
	 */
	public function addSimpleParameter($name, $type = null, $defaultValue = null)
	{
		$parameter = new PhpParameter($name);
		$parameter->setType($type);

		if (2 < func_num_args()) {
			$parameter->setDefaultValue($defaultValue);
		}

		$this->addParameter($parameter);
		return $this;
	}

	/**
	 * @param string      $name
	 * @param null|string $type
	 * @param null|string $typeDescription
	 * @param mixed       $defaultValue omit the argument to define now default value
	 *
	 * @return $this
	 */
	public function addSimpleDescParameter($name, $type = null, $typeDescription = null, $defaultValue = null)
	{
		$parameter = new PhpParameter($name);
		$parameter->setType($type);
		$parameter->setTypeDescription($typeDescription);

		if (3 < func_num_args()) {
			$parameter->setDefaultValue($defaultValue);
		}

		$this->addParameter($parameter);
		return $this;
	}

	/**
	 *
	 * @param string|integer $nameOrIndex
	 *
	 * @return PhpParameter
	 */
	public function getParameter($nameOrIndex) {
		if (is_int($nameOrIndex)) {
			if (!isset($this->parameters[$nameOrIndex])) {
				throw new \InvalidArgumentException(sprintf('There is no parameter at position %d.', $nameOrIndex));
			}

			return $this->parameters[$nameOrIndex];
		}

		foreach ($this->parameters as $param) {
			assert($param instanceof PhpParameter);

			if ($param->getName() === $nameOrIndex) {
				return $param;
			}
		}

		throw new \InvalidArgumentException(sprintf('There is no parameter named "%s".', $nameOrIndex));
	}

	public function replaceParameter($position, PhpParameter $parameter) {
		if ($position < 0 || $position > count($this->parameters)) {
			throw new \InvalidArgumentException(sprintf('The position must be in the range [0, %d].', count($this->parameters)));
		}
		$this->parameters[$position] = $parameter;

		return $this;
	}

	/**
	 *
	 * @param integer $position
	 */
	public function removeParameter($position) {
		if (!isset($this->parameters[$position])) {
			throw new \InvalidArgumentException(sprintf('There is no parameter at position "%d" does not exist.', $position));
		}
		unset($this->parameters[$position]);
		$this->parameters = array_values($this->parameters);

		return $this;
	}

	public function getParameters() {
		return $this->parameters;
	}
}