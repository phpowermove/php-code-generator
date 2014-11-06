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
namespace gossi\codegen\model;

use gossi\docblock\tags\VarTag;
use gossi\docblock\Docblock;
use gossi\codegen\model\parts\DefaultValueTrait;

/**
 * Represents a PHP property.
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
class PhpProperty extends AbstractPhpMember {
	
	use DefaultValueTrait;

	/**
	 * @param string|null $name
	 */
	public static function create($name) {
		return new static($name);
	}

	public static function fromReflection(\ReflectionProperty $ref) {
		$property = new static($ref->name);
		$property->setStatic($ref->isStatic())
			->setVisibility($ref->isPublic() ? self::VISIBILITY_PUBLIC : ($ref->isProtected() ? self::VISIBILITY_PROTECTED : self::VISIBILITY_PRIVATE));

		$docblock = new Docblock($ref);
		$property->setDocblock($docblock);
		$property->setDescription($docblock->getShortDescription());
		
		$defaultProperties = $ref->getDeclaringClass()->getDefaultProperties();
		if (isset($defaultProperties[$ref->name])) {
			$property->setDefaultValue($defaultProperties[$ref->name]);
		}
		
		return $property;
	}

	public function generateDocblock() {
		$docblock = $this->getDocblock();
		$docblock->setShortDescription($this->getDescription());
		$docblock->setLongDescription($this->getLongDescription());
		
		$type = $this->getType();
		if (!empty($type)) {
			$docblock->appendTag(VarTag::create()
				->setType($type)
				->setDescription($this->getTypeDescription())
			);
		}
	}
}
