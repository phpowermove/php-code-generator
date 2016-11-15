<?php
namespace gossi\codegen\model;

use gossi\docblock\Docblock;

/**
 * Docblock interface to represent models that have a docblock
 *
 * Implementation is realized in the `DocblockPart`
 *
 * @author Thomas Gossmann
 */
interface DocblockInterface {

	/**
	 * Sets a docblock
	 *
	 * @param Docblock|string $doc
	 * @return $this
	 */
	public function setDocblock($doc);

	/**
	 * Returns a docblock
	 *
	 * @return Docblock
	 */
	public function getDocblock();
	
	/**
	 * Generates a docblock from provided information
	 *
	 * @return $this
	 */
	public function generateDocblock();
}
