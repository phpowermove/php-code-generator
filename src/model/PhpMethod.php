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

use gossi\codegen\model\parts\AbstractTrait;
use gossi\codegen\model\parts\BodyTrait;
use gossi\codegen\model\parts\FinalTrait;
use gossi\codegen\model\parts\ParamDocblockGeneratorTrait;
use gossi\codegen\model\parts\ParametersTrait;
use gossi\codegen\model\parts\ReferenceReturnTrait;
use gossi\codegen\model\parts\TypeDocblockGeneratorTrait;
use gossi\codegen\utils\ReflectionUtils;
use gossi\docblock\Docblock;
use gossi\docblock\tags\ReturnTag;

/**
 * Represents a PHP method.
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
class PhpMethod extends AbstractPhpMember {
	
	use AbstractTrait;
	use FinalTrait;
	use ParametersTrait;
	use BodyTrait;
	use ReferenceReturnTrait;
	use TypeDocblockGeneratorTrait;
	use ParamDocblockGeneratorTrait;

	/**
	 * Creates a new PHP method.
	 * 
	 * @param string $name the method name	
	 */
	public static function create($name) {
		return new static($name);
	}

	/**
	 * Creates a PHP method from reflection
	 * 
	 * @param \ReflectionMethod $ref
	 * @return PhpMethod
	 */
	public static function fromReflection(\ReflectionMethod $ref) {
		$method = new static($ref->name);
		$method->setFinal($ref->isFinal())
			->setAbstract($ref->isAbstract())
			->setStatic($ref->isStatic())
			->setVisibility($ref->isPublic() 
				? self::VISIBILITY_PUBLIC 
				: ($ref->isProtected() 
					? self::VISIBILITY_PROTECTED 
					: self::VISIBILITY_PRIVATE))
			->setReferenceReturned($ref->returnsReference())
			->setBody(ReflectionUtils::getFunctionBody($ref));

		$docblock = new Docblock($ref);
		$method->setDocblock($docblock);
		$method->setDescription($docblock->getShortDescription());
		$method->setLongDescription($docblock->getLongDescription());
		
		// return type and description
		$returns = $method->getDocblock()->getTags('return');
		if ($returns->size() > 0) {
			$return = $returns->get(0);
			$method->setType($return->getType(), $return->getDescription());
		}
		
		// params
		foreach ($ref->getParameters() as $param) {
			$method->addParameter(static::createParameter($param));
		}
		
		return $method;
	}

	/**
	 * @return PhpParameter
	 */
	protected static function createParameter(\ReflectionParameter $parameter) {
		return PhpParameter::fromReflection($parameter);
	}

	public function generateDocblock() {
		$docblock = $this->getDocblock();
		$docblock->setShortDescription($this->getDescription());
		$docblock->setLongDescription($this->getLongDescription());
		
		// return tag
		$this->generateTypeTag(new ReturnTag());
		
		// param tags
		$this->generateParamDocblock();
	}
}
