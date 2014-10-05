<?php
namespace gossi\codegen\model\parts;

trait BodyTrait {

	private $body = '';

	/**
	 *
	 * @param string $body        	
	 */
	public function setBody($body) {
		$this->body = $body;
		
		return $this;
	}

	public function getBody() {
		return $this->body;
	}
}