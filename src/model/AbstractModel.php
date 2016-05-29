<?php
namespace gossi\codegen\model;

/**
 * Parent of all models
 *
 * @author Thomas Gossmann
 */
abstract class AbstractModel {

	/** @var array */
	private $attributes = [];

	/** @var string */
	protected $description;

	/**
	 * Sets a custom user attribute
	 *
	 * @deprecated See: https://github.com/gossi/php-code-generator/issues/29
	 * @param string $key
	 * @param mixed $value
	 * @return $this
	 */
	public function setAttribute($key, $value) {
		$this->attributes[$key] = $value;

		return $this;
	}

	/**
	 * Removes and returns a custom user attribute
	 *
	 * @deprecated See: https://github.com/gossi/php-code-generator/issues/29
	 * @param string $key
	 * @return mixed
	 */
	public function removeAttribute($key) {
		$val = $this->attributes[$key];
		unset($this->attributes[$key]);
		return $val;
	}

	/**
	 * Returns a custom user attribute
	 *
	 * @deprecated See: https://github.com/gossi/php-code-generator/issues/29
	 * @param string $key
	 * @throws \InvalidArgumentException if the key cannot be found
	 * @return mixed
	 */
	public function getAttribute($key) {
		if (!isset($this->attributes[$key])) {
			throw new \InvalidArgumentException(sprintf('There is no attribute named "%s".', $key));
		}

		return $this->attributes[$key];
	}

	/**
	 * Returns a custom user attribute or the default value if the attribute doesn't exist
	 *
	 * @deprecated See: https://github.com/gossi/php-code-generator/issues/29
	 * @param string $key
	 * @param mixed $default
	 * @return mixed
	 */
	public function getAttributeOrElse($key, $default) {
		if (!isset($this->attributes[$key])) {
			return $default;
		}

		return $this->attributes[$key];
	}

	/**
	 * Checks whether an attribute exists
	 *
	 * @deprecated See: https://github.com/gossi/php-code-generator/issues/29
	 * @param string $key
	 * @return bool
	 */
	public function hasAttribute($key) {
		return isset($this->attributes[$key]);
	}

	/**
	 * Sets custom user attributes
	 *
	 * @deprecated See: https://github.com/gossi/php-code-generator/issues/29
	 * @param array $attrs
	 * @return $this
	 */
	public function setAttributes(array $attrs) {
		$this->attributes = $attrs;

		return $this;
	}

	/**
	 * Returns all custom user attributes
	 *
	 * @deprecated See: https://github.com/gossi/php-code-generator/issues/29
	 * @return array
	 */
	public function getAttributes() {
		return $this->attributes;
	}

	/**
	 * Returns this description
	 *
	 * @return string
	 */
	public function getDescription() {
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
		$this->description = $description;
		return $this;
	}

}
