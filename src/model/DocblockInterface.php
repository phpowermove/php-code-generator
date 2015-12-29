<?php
namespace gossi\codegen\model;

use gossi\docblock\Docblock;

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
}