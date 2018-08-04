<?php
namespace gossi\codegen\model\parts;

use gossi\codegen\model\PhpInterface;
use phootwork\collection\Set;

/**
 * Interfaces part
 *
 * For all models that can contain interfaces
 *
 * @author Thomas Gossmann
 */
trait InterfacesPart {

	/** @var Set */
	private $interfaces;

	private function initInterfaces() {
		$this->interfaces = new Set();
	}

	/**
	 * Adds a use statement with an optional alias
	 *
	 * @param string $qualifiedName
	 * @param null|string $alias
	 * @return $this
	 */
	abstract public function addUseStatement($qualifiedName, $alias = null);

	/**
	 * Removes a use statement
	 *
	 * @param string $qualifiedName
	 * @return $this
	 */
	abstract public function removeUseStatement($qualifiedName);

	/**
	 * Returns the namespace
	 *
	 * @return string
	 */
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

		$this->interfaces->add($name);

		return $this;
	}

	/**
	 * Returns the interfaces
	 *
	 * @return Set
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
		return !$this->interfaces->isEmpty();
	}

	/**
	 * Checks whether an interface exists
	 *
	 * @param PhpInterface|string $interface interface name or instance
	 * @return bool
	 */
	public function hasInterface($interface) {
		if ($interface instanceof PhpInterface) {
			return $this->interfaces->contains($interface->getName())
				|| $this->interfaces->contains($interface->getQualifiedName());
		}

		return $this->interfaces->contains($interface) || $this->hasInterface(new PhpInterface($interface));
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

		$this->interfaces->remove($name);

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
