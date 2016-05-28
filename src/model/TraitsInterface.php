<?php
namespace gossi\codegen\model;

interface TraitsInterface {

	/**
	 * Adds a trait.
	 * 
	 * If the trait is passed as PhpTrait object, 
	 * the trait is also added as use statement.
	 *
	 * @param PhpTrait|string $trait trait or qualified name
	 * @return $this
	 */
	public function addTrait($trait);

	/**
	 * Returns a collection of traits
	 * 
	 * @return string[]
	 */
	public function getTraits();

	/**
	 * Checks whether a trait exists
	 * 
	 * @param PhpTrait|string $trait
	 * @return boolean `true` if it exists and `false` if not
	 */
	public function hasTrait($trait);

	/**
	 * Removes a trait. 
	 * 
	 * If the trait is passed as PhpTrait object, 
	 * the trait is also removed from use statements.
	 *
	 * @param PhpTrait|string $trait trait or qualified name
	 * @return $this
	 */
	public function removeTrait($trait);

	/**
	 * Sets a collection of traits
	 * 
	 * @param PhpTrait[] $traits
	 * @return $this
	 */
	public function setTraits(array $traits);
}