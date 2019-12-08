<?php
declare(strict_types=1);

namespace gossi\codegen\model;

/**
 * Parent of all models
 *
 * @author Thomas Gossmann
 */
abstract class AbstractModel {

	/** @var string */
	protected $description;

	/**
	 * Returns this description
	 *
	 * @return string
	 */
	public function getDescription(): ?string {
		return $this->description;
	}

	/**
	 * Sets the description, which will also be used when generating a docblock
	 *
	 * @param string|array $description
	 * @return $this
	 */
	public function setDescription($description) {
		if (is_array($description)) {
			$description = implode("\n", $description);
		}
		if ($description) {
            $this->description = $description;
        }
		return $this;
	}

}
