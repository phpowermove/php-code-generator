<?php
declare(strict_types=1);

namespace phpowermove\codegen\model;

/**
 * Represents models that can have traits
 *
 * @author Thomas Gossmann
 */
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
	 * @return bool `true` if it exists and `false` if not
	 */
	public function hasTrait($trait): bool;

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
