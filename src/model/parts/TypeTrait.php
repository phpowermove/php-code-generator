<?php
namespace gossi\codegen\model\parts;

trait TypeTrait {

	private $type;

	private $typeDescription;

	/**
	 *
	 * @param string      $type
	 * @param null|string $description
	 */
	public function setType($type, $description = null) {
		$this->type = $type;
		if (null !== $description) {
			$this->setTypeDescription($description);
		}
		
		return $this;
	}

	public function setTypeDescription($description) {
		$this->typeDescription = $description;
		return $this;
	}

	public function getType() {
		return $this->type;
	}

	public function getTypeDescription() {
		return $this->typeDescription;
	}
}