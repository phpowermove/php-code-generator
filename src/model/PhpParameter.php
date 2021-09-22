<?php
/*
 * Copyright 2011 Johannes M. Schmitt <schmittjoh@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
declare(strict_types=1);

namespace phpowermove\codegen\model;

use phpowermove\codegen\model\parts\NamePart;
use phpowermove\codegen\model\parts\TypePart;
use phpowermove\codegen\model\parts\ValuePart;
use phpowermove\docblock\tags\ParamTag;

/**
 * Represents a PHP parameter.
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 * @author Thomas Gossmann
 */
class PhpParameter extends AbstractModel implements ValueInterface {

	use NamePart;
	use TypePart;
	use ValuePart;

	private $passedByReference = false;

	/**
	 * Creates a new PHP parameter.
	 *
	 * @param string $name the parameter name
	 * @return static
	 */
	public static function create($name = null) {
		return new static($name);
	}

	/**
	 * Creates a new PHP parameter
	 *
	 * @param string $name the parameter name
	 */
	public function __construct($name = null) {
		$this->setName($name);
	}

	/**
	 * Sets whether this parameter is passed by reference
	 *
	 * @param bool $bool `true` if passed by reference and `false` if not
	 * @return $this
	 */
	public function setPassedByReference(bool $bool) {
		$this->passedByReference = $bool;

		return $this;
	}

	/**
	 * Returns whether this parameter is passed by reference
	 *
	 * @return bool `true` if passed by reference and `false` if not
	 */
	public function isPassedByReference(): bool {
		return $this->passedByReference;
	}

	/**
	 * Returns a docblock tag for this parameter
	 *
	 * @return ParamTag
	 */
	public function getDocblockTag(): ParamTag {
		return ParamTag::create()
			->setType($this->getType())
			->setVariable($this->getName())
			->setDescription($this->getTypeDescription());
	}

	/**
	 * Alias for setDescription()
	 *
	 * @see #setDescription
	 * @param string $description
	 * @return $this
	 */
	public function setTypeDescription(?string $description) {
		return $this->setDescription($description);
	}

	/**
	 * Alias for getDescription()
	 *
	 * @see #getDescription
	 * @return string
	 */
	public function getTypeDescription(): ?string {
		return $this->getDescription();
	}
}
