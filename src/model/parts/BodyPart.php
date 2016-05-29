<?php
namespace gossi\codegen\model\parts;

/**
 * Body Part
 *
 * For all models that do have a code body
 *
 * @author Thomas Gossmann
 */
trait BodyPart {

	/** @var string */
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
