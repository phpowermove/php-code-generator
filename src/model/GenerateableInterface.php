<?php
namespace gossi\codegen\model;

interface GenerateableInterface {

	/**
	 * Generates docblock based on provided information
	 *
	 * @return Docblock
	 */
	public function generateDocblock();
}