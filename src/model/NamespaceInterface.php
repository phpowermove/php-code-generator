<?php
namespace gossi\codegen\model;

/**
 * Represents models that have a namespace
 *
 * @author Thomas Gossmann
 */
interface NamespaceInterface {

	/**
	 * Sets the namespace
	 *
	 * @param string $namespace
	 * @return $this
	 */
	public function setNamespace($namespace);

	/**
	 * Returns the namespace
	 *
	 * @return string
	 */
	public function getNamespace();
}
