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

use gossi\docblock\Docblock;
use gossi\docblock\tags\ReturnTag;
use gossi\codegen\model\parts\QualifiedNameTrait;
use gossi\codegen\model\parts\DocblockTrait;
use gossi\codegen\model\parts\ParametersTrait;
use gossi\codegen\model\parts\BodyTrait;
use gossi\codegen\model\parts\ReferenceReturnTrait;
use gossi\codegen\model\parts\TypeTrait;
use gossi\codegen\model\parts\LongDescriptionTrait;
use gossi\codegen\utils\ReflectionUtils;
use gossi\codegen\model\parts\TypeDocblockGeneratorTrait;
use gossi\codegen\model\parts\ParamDocblockGeneratorTrait;

/**
 * Represents a PHP function.
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
class PhpFunction extends AbstractModel implements GenerateableInterface, NamespaceInterface, DocblockInterface {

	use QualifiedNameTrait;
	use DocblockTrait;
	use ParametersTrait;
	use BodyTrait;
	use ReferenceReturnTrait;
	use TypeTrait;
	use LongDescriptionTrait;
	use TypeDocblockGeneratorTrait;
	use ParamDocblockGeneratorTrait;

	/**
	 * Creates a PHP function from reflection
	 *
	 * @param \ReflectionFunction $ref
	 * @return PhpFunction
	 */
	public static function fromReflection(\ReflectionFunction $ref) {
		$function = PhpFunction::create($ref->name)
			->setReferenceReturned($ref->returnsReference())
			->setBody(ReflectionUtils::getFunctionBody($ref));
		
		$docblock = new Docblock($ref);
		$function->setDocblock($docblock);
		$function->setDescription($docblock->getShortDescription());
		$function->setLongDescription($docblock->getLongDescription());
		
		foreach ($ref->getParameters() as $refParam) {
			assert($refParam instanceof \ReflectionParameter); // hmm - assert here?
			
			$param = PhpParameter::fromReflection($refParam);
			$function->addParameter($param);
		}
		
		return $function;
	}

	/**
	 * Creates a new PHP function
	 * 
	 * @param string $name qualified name
	 * @return static
	 */
	public static function create($name = null) {
		return new static($name);
	}

	/**
	 * Creates a new PHP function
	 *
	 * @param string $name qualified name
	 */
	public function __construct($name = null) {
		$this->setQualifiedName($name);
		$this->docblock = new Docblock();
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
