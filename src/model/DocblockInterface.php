<?php
declare(strict_types=1);

namespace phpowermove\codegen\model;

use phpowermove\docblock\Docblock;

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
	public function getDocblock(): Docblock;

	/**
	 * Generates a docblock from provided information
	 *
	 * @return $this
	 */
	public function generateDocblock();
}
