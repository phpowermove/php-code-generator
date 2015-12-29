<?php
namespace gossi\codegen\model;

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