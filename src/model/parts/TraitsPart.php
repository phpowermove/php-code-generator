<?php
namespace gossi\codegen\model\parts;

use gossi\codegen\model\PhpTrait;

/**
 * Traits part
 *
 * For all models that can have traits
 *
 * @author Thomas Gossmann
 */
trait TraitsPart {

	/** @var array */
	private $traits = [];

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
	 * Adds a trait.
	 *
	 * If the trait is passed as PhpTrait object,
	 * the trait is also added as use statement.
	 *
	 * @param PhpTrait|string $trait trait or qualified name
	 * @return $this
	 */
	public function addTrait($trait) {
		if ($trait instanceof PhpTrait) {
			$name = $trait->getName();
			$qname = $trait->getQualifiedName();
			$namespace = $trait->getNamespace();

			if ($namespace != $this->getNamespace()) {
				$this->addUseStatement($qname);
			}
		} else {
			$name = $trait;
		}

		if (!in_array($name, $this->traits)) {
			$this->traits[] = $name;
		}

		return $this;
	}

	/**
	 * Returns a collection of traits
	 *
	 * @return string[]
	 */
	public function getTraits() {
		return $this->traits;
	}

	/**
	 * Checks whether a trait exists
	 *
	 * @param PhpTrait|string $trait
	 * @return bool `true` if it exists and `false` if not
	 */
	public function hasTrait($trait) {
		if (!$trait instanceof PhpTrait) {
			$trait = new PhpTrait($trait);
		}
		$name = $trait->getName();
		return in_array($name, $this->traits);
	}

	/**
	 * Removes a trait.
	 *
	 * If the trait is passed as PhpTrait object,
	 * the trait is also removed from use statements.
	 *
	 * @param PhpTrait|string $trait trait or qualified name
	 * @return $this
	 */
	public function removeTrait($trait) {
		if ($trait instanceof PhpTrait) {
			$name = $trait->getName();
		} else {
			$name = $trait;
		}

		$index = array_search($name, $this->traits);
		if ($index !== false) {
			unset($this->traits[$index]);

			if ($trait instanceof PhpTrait) {
				$qname = $trait->getQualifiedName();
				$this->removeUseStatement($qname);
			}
		}

		return $this;
	}

	/**
	 * Sets a collection of traits
	 *
	 * @param PhpTrait[] $traits
	 * @return $this
	 */
	public function setTraits(array $traits) {
		foreach ($traits as $trait) {
			$this->addTrait($trait);
		}

		return $this;
	}
}
