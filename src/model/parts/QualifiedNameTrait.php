<?php
namespace gossi\codegen\model\parts;

trait QualifiedNameTrait {

	use NameTrait;

	private $namespace;

	/**
	 * Sets the namespace
	 * 
	 * @param string $namespace        	
	 * @return $this
	 */
	public function setNamespace($namespace) {
		$this->namespace = $namespace;

		return $this;
	}

	/**
	 * In contrast to setName(), this method accepts the fully qualified name
	 * including the namespace.
	 *
	 * @param string $name        	
	 * @return $this
	 */
	public function setQualifiedName($name) {
		if (false !== $pos = strrpos($name, '\\')) {
			$this->namespace = trim(substr($name, 0, $pos), '\\');
			$this->name = substr($name, $pos + 1);

			return $this;
		}

		$this->namespace = null;
		$this->name = $name;

		return $this;
	}

	/**
	 * Returns the namespace
	 * 
	 * @return string
	 */
	public function getNamespace() {
		return $this->namespace;
	}

	/**
	 * Returns the qualified name
	 * 
	 * @return string
	 */
	public function getQualifiedName() {
		if ($this->namespace) {
			return $this->namespace . '\\' . $this->name;
		}

		return $this->name;
	}
}