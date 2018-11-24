<?php
declare(strict_types=1);

namespace gossi\codegen\model\parts;

use gossi\codegen\model\PhpParameter;
use gossi\docblock\tags\ParamTag;
use gossi\docblock\Docblock;

/**
 * Parameters Part
 *
 * For all models that can have parameters
 *
 * @author Thomas Gossmann
 */
trait ParametersPart {

	/** @var array */
	private $parameters = [];

	private function initParameters() {
// 		$this->parameters = new ArrayList();
	}

	/**
	 * Sets a collection of parameters
	 *
	 * Note: clears all parameters before setting the new ones
	 *
	 * @param PhpParameter[] $parameters
	 * @return $this
	 */
	public function setParameters(array $parameters) {
		$this->parameters = [];
		foreach ($parameters as $parameter) {
			$this->addParameter($parameter);
		}

		return $this;
	}

	/**
	 * Adds a parameter
	 *
	 * @param PhpParameter $parameter
	 * @return $this
	 */
	public function addParameter(PhpParameter $parameter) {
		$this->parameters[] = $parameter;

		return $this;
	}

	/**
	 * Checks whether a parameter exists
	 *
	 * @param string $name parameter name
	 * @return bool `true` if a parameter exists and `false` if not
	 */
	public function hasParameter(string $name): bool {
		foreach ($this->parameters as $param) {
			if ($param->getName() == $name) {
				return true;
			}
		}

		return false;
	}

	/**
	 * A quick way to add a parameter which is created from the given parameters
	 *
	 * @param string      $name
	 * @param null|string $type
	 * @param mixed       $defaultValue omit the argument to define no default value
	 *
	 * @return $this
	 */
	public function addSimpleParameter(string $name, string $type = null, $defaultValue = null) {
		$parameter = new PhpParameter($name);
		$parameter->setType($type);

		if (2 < func_num_args()) {
			$parameter->setValue($defaultValue);
		}

		$this->addParameter($parameter);
		return $this;
	}

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
	public function addSimpleDescParameter(string $name, string $type = null, string $typeDescription = null, $defaultValue = null) {
		$parameter = new PhpParameter($name);
		$parameter->setType($type);
		$parameter->setTypeDescription($typeDescription);

		if (3 < func_num_args() == 3) {
			$parameter->setValue($defaultValue);
		}

		$this->addParameter($parameter);
		return $this;
	}

	/**
	 * Returns a parameter by index or name
	 *
	 * @param string|int $nameOrIndex
	 * @throws \InvalidArgumentException
	 * @return PhpParameter
	 */
	public function getParameter($nameOrIndex): PhpParameter {
		if (is_int($nameOrIndex)) {
			$this->checkPosition($nameOrIndex);
			return $this->parameters[$nameOrIndex];
		}

		foreach ($this->parameters as $param) {
			if ($param->getName() === $nameOrIndex) {
				return $param;
			}
		}

		throw new \InvalidArgumentException(sprintf('There is no parameter named "%s".', $nameOrIndex));
	}

	/**
	 * Replaces a parameter at a given position
	 *
	 * @param int $position
	 * @param PhpParameter $parameter
	 * @throws \InvalidArgumentException
	 * @return $this
	 */
	public function replaceParameter(int $position, PhpParameter $parameter) {
		$this->checkPosition($position);
		$this->parameters[$position] = $parameter;

		return $this;
	}

	/**
	 * Remove a parameter at a given position
	 *
	 * @param int|string|PhpParameter $param
	 * @return $this
	 */
	public function removeParameter($param) {
		if (is_int($param)) {
			$this->removeParameterByPosition($param);
		} else if (is_string($param)) {
			$this->removeParameterByName($param);
		} else if ($param instanceof PhpParameter) {
			$this->removeParameterByName($param->getName());
		}

		return $this;
	}

	private function removeParameterByPosition($position) {
		$this->checkPosition($position);
		unset($this->parameters[$position]);
		$this->parameters = array_values($this->parameters);
	}

	private function removeParameterByName($name) {
		$position = null;
		foreach ($this->parameters as $index => $param) {
			if ($param->getName() == $name) {
				$position = $index;
			}
		}

		if ($position !== null) {
			$this->removeParameterByPosition($position);
		}
	}

	private function checkPosition($position) {
		if ($position < 0 || $position > count($this->parameters)) {
			throw new \InvalidArgumentException(sprintf('The position must be in the range [0, %d].', count($this->parameters)));
		}
	}

	/**
	 * Returns a collection of parameters
	 *
	 * @return array
	 */
	public function getParameters() {
		return $this->parameters;
	}

	/**
	 * Returns the docblock
	 *
	 * @return Docblock
	 */
	abstract protected function getDocblock(): Docblock;

	/**
	 * Generates docblock for params
	 */
	protected function generateParamDocblock() {
		$docblock = $this->getDocblock();
		$tags = $docblock->getTags('param');
		foreach ($this->parameters as $param) {
			$ptag = $param->getDocblockTag();

			$tag = $tags->find($ptag, function (ParamTag $tag, ParamTag $ptag) {
				return $tag->getVariable() == $ptag->getVariable();
			});

			// try to update existing docblock first
			if ($tag !== null) {
				$tag->setDescription($ptag->getDescription());
				$tag->setType($ptag->getType());
			}

			// ... append if it doesn't exist
			else {
				$docblock->appendTag($ptag);
			}
		}
	}

}
