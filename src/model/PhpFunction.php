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

use gossi\codegen\model\parts\BodyPart;
use gossi\codegen\model\parts\DocblockPart;
use gossi\codegen\model\parts\LongDescriptionPart;
use gossi\codegen\model\parts\ParametersPart;
use gossi\codegen\model\parts\QualifiedNamePart;
use gossi\codegen\model\parts\ReferenceReturnPart;
use gossi\codegen\model\parts\TypeDocblockGeneratorPart;
use gossi\codegen\model\parts\TypePart;
use gossi\docblock\Docblock;
use gossi\docblock\tags\ReturnTag;

/**
 * Represents a PHP function.
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 * @author Thomas Gossmann
 * @deprecated Not a structural model. Please refer to https://github.com/gossi/php-code-generator/issues/35 and join the discussion if you really need this
 */
class PhpFunction extends AbstractModel implements GenerateableInterface, NamespaceInterface, DocblockInterface, RoutineInterface {

	use BodyPart;
	use DocblockPart;
	use LongDescriptionPart;
	use ParametersPart;
	use QualifiedNamePart;
	use ReferenceReturnPart;
	use TypeDocblockGeneratorPart;
	use TypePart;

// 	/**
// 	 * Creates a PHP function from reflection
// 	 *
// 	 * @deprecated will be removed in version 0.5
// 	 * @param \ReflectionFunction $ref
// 	 * @return PhpFunction
// 	 */
// 	public static function fromReflection(\ReflectionFunction $ref) {
// 		$function = self::create($ref->name)
// 			->setReferenceReturned($ref->returnsReference())
// 			->setBody(ReflectionUtils::getFunctionBody($ref));

// 		$docblock = new Docblock($ref);
// 		$function->setDocblock($docblock);
// 		$function->setDescription($docblock->getShortDescription());
// 		$function->setLongDescription($docblock->getLongDescription());

// 		foreach ($ref->getParameters() as $refParam) {
// 			assert($refParam instanceof \ReflectionParameter); // hmm - assert here?

// 			$param = PhpParameter::fromReflection($refParam);
// 			$function->addParameter($param);
// 		}

// 		return $function;
// 	}

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
		$this->initParameters();
	}

	/**
	 * @inheritDoc
	 */
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
