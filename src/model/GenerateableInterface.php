<?php
namespace gossi\codegen\model;

interface GenerateableInterface {

	/**
	 * Generates docblock based on provided information
	 */
	public function generateDocblock();
}