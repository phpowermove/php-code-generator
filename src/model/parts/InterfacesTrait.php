<?php
namespace gossi\codegen\model\parts;

use gossi\codegen\model\PhpInterface;

trait InterfacesTrait {

	private $interfaces = [];

	abstract public function addUseStatement($qualifiedName, $alias = null);

	abstract public function removeUseStatement($qualifiedName);

	abstract public function getNamespace();

	/**
	 * Adds an interface.
	 * 
	 * If the interface is passed as PhpInterface object, 
	 * the interface is also added as use statement.
	 *
	 * @param PhpInterface|string $interface interface or qualified name
	 * @return $this
	 */
	public function addInterface($interface) {
		if ($interface instanceof PhpInterface) {
			$name = $interface->getName();
			$qname = $interface->getQualifiedName();
			$namespace = $interface->getNamespace();

			if ($namespace != $this->getNamespace()) {
				$this->addUseStatement($qname);
			}
		} else {
			$name = $interface;
		}

		if (!in_array($name, $this->interfaces)) {
			$this->interfaces[] = $name;
		}

		return $this;
	}

	/**
	 * Returns the interfaces
	 * 
	 * @return PhpInterface[]
	 */
	public function getInterfaces() {
		return $this->interfaces;
	}

	/**
	 * Checks whether interfaces exists
	 * 
	 * @return bool `true` if interfaces are available and `false` if not
	 */
	public function hasInterfaces() {
		return count($this->interfaces) > 0;
	}

	/**
	 * Checks whether an interface exists
	 * 
	 * @param PhpInterface|string $interface interface name or instance        	
	 * @return bool
	 */
	public function hasInterface($interface) {
		if (!$interface instanceof PhpInterface) {
			$interface = new PhpInterface($interface);
		}
		$name = $interface->getName();
		return in_array($name, $this->interfaces);
	}

	/**
	 * Removes an interface.
	 * 
	 * If the interface is passed as PhpInterface object, 
	 * the interface is also remove from the use statements.
	 *
	 * @param PhpInterface|string $interface interface or qualified name
	 * @return $this
	 */
	public function removeInterface($interface) {
		if ($interface instanceof PhpInterface) {
			$name = $interface->getName();
			$qname = $interface->getQualifiedName();

			$this->removeUseStatement($qname);
		} else {
			$name = $interface;
		}

		$index = array_search($name, $this->interfaces);
		if ($index) {
			unset($this->interfaces[$name]);
		}

		return $this;
	}

	/**
	 * Sets a collection of interfaces
	 * 
	 * @param PhpInterface[] $interfaces        	
	 * @return $this
	 */
	public function setInterfaces(array $interfaces) {
		foreach ($interfaces as $interface) {
			$this->addInterface($interface);
		}

		return $this;
	}
}
