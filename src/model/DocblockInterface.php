<?php
namespace gossi\codegen\model;

use gossi\docblock\Docblock;

interface DocblockInterface {

	/**
	 *
	 * @param Docblock|string $doc        	
	 * @return $this
	 */
	public function setDocblock($doc);

	/**
	 *
	 * @return Docblock
	 */
	public function getDocblock();
}