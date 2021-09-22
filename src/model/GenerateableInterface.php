<?php
declare(strict_types=1);

namespace phpowermove\codegen\model;

/**
 * Represents all models that can be generated with a code generator
 *
 * @author Thomas Gossmann
 */
interface GenerateableInterface {

	/**
	 * Generates docblock based on provided information
	 * 
	 * @return void
	 */
	public function generateDocblock(): void;
}
