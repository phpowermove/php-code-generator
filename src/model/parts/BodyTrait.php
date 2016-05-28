<?php
namespace gossi\codegen\model\parts;

trait BodyTrait {

	private $body = '';

	/**
	 * Sets the body for this
	 * 
	 * @param string $body
	 * @return $this        	
	 */
	public function setBody($body) {
		$this->body = $body;

		return $this;
	}

	/**
	 * Returns the body
	 * 
	 * @return string
	 */
	public function getBody() {
		return $this->body;
	}
}