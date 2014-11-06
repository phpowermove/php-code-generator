<?php
namespace gossi\codegen\model\parts;

use gossi\docblock\Docblock;

trait DocblockTrait {

	/**
	 *
	 * @var Docblock
	 */
	private $docblock;

	/**
	 *
	 * @param Docblock|string $doc        	
	 * @return $this
	 */
	public function setDocblock($doc) {
		if (is_string($doc)) {
			$doc = trim($doc);
			$doc = new Docblock($doc);
		}
		$this->docblock = $doc;
		
		return $this;
	}

	/**
	 *
	 * @return Docblock
	 */
	public function getDocblock() {
		if ($this->docblock === null) {
			$this->docblock = new Docblock();
		}
		return $this->docblock;
	}
}
