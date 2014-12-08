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
use gossi\codegen\model\parts\QualifiedNameTrait;
use gossi\codegen\model\parts\DocblockTrait;
use gossi\codegen\model\parts\LongDescriptionTrait;

/**
 * Represents an abstract php struct.
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
abstract class AbstractPhpStruct extends AbstractModel implements NamespaceInterface, DocblockInterface {
	
	use QualifiedNameTrait;
	use DocblockTrait;
	use LongDescriptionTrait;

	protected static $phpParser;

	private $useStatements = [];

	private $requiredFiles = [];

	/**
	 *
	 * @var PhpMethod[]
	 */
	private $methods = [];

	public static function create($name = null) {
		return new static($name);
	}

	/**
	 *
	 * @return PhpMethod
	 */
	protected static function createMethod(\ReflectionMethod $method) {
		return PhpMethod::fromReflection($method);
	}

	/**
	 *
	 * @return PhpProperty
	 */
	protected static function createProperty(\ReflectionProperty $property) {
		return PhpProperty::fromReflection($property);
	}

	public function __construct($name = null) {
		$this->setQualifiedName($name);
		$this->docblock = new Docblock();
	}

	public function setRequiredFiles(array $files) {
		$this->requiredFiles = $files;
		
		return $this;
	}

	/**
	 *
	 * @param string $file        	
	 */
	public function addRequiredFile($file) {
		$this->requiredFiles[] = $file;
		
		return $this;
	}

	public function setUseStatements(array $useStatements) {
		$this->useStatements = [];
		foreach ($useStatements as $alias => $useStatement) {
			$this->addUseStatement($useStatement, $alias);
		}

		return $this;
	}

	/**
	 *
	 * @param string $qualifiedName
	 * @param null|string $alias
	 * @return $this
	 */
	public function addUseStatement($qualifiedName, $alias = null) {
		if (!is_string($alias)) {
			if (false === strpos($qualifiedName, '\\')) {
				$alias = $qualifiedName;
			} else {
				$alias = substr($qualifiedName, strrpos($qualifiedName, '\\') + 1);
			}
		}
		
		$this->useStatements[$alias] = $qualifiedName;
		
		return $this;
	}

	/**
	 *  Declares multiple use statements at once.
	 */
	public function declareUses()
 	{
 		foreach (func_get_args() as $name) {
 			$this->declareUse($name);
 		}
 	}
	
	/**
	 * Declares a "use $fullClassName" with " as $alias" if $alias is available,
	 * and returns its alias (or not qualified classname) to be used in your actual
	 * php code.
	 * 
	 * If the class has already been declared you get only the set alias.
	 * 
 	 * @param string      $fullClassName
 	 * @param null|string $alias
 	 *
 	 * @return string
 	 */
 	public function declareUse($fullClassName, $alias = null)
	{
 		$fullClassName = trim($fullClassName, '\\');
 		if (!$this->hasUseStatement($fullClassName)) {
 			$this->addUseStatement($fullClassName, $alias);
 		}
		return $this->getUseAlias($fullClassName);
 	}

	/**
	 * Returns whether the given use statement is present
	 *
	 * @param string $qualifiedName        	
	 * @return boolean
	 */
	public function hasUseStatement($qualifiedName) {
		$flipped = array_flip($this->useStatements);
		return isset($flipped[$qualifiedName]);
	}

	/**
	 * @param string $qualifiedName
	 * @return string
	 */
	public function getUseAlias($qualifiedName) {
		$flipped = array_flip($this->useStatements);
		return $flipped[$qualifiedName];
	}

	public function removeUseStatement($qualifiedName) {
		$offset = array_search($qualifiedName, $this->useStatements);
		if ($offset !== null) {
			unset($this->useStatements[$offset]);
		}
	}

	/**
	 *
	 * @param PhpMethod[] $methods        	
	 * @return $this
	 */
	public function setMethods(array $methods) {
		foreach ($this->methods as $method) {
			$method->setParent(null);
		}
		
		$this->methods = [];
		foreach ($methods as $method) {
			$this->setMethod($method);
		}
		
		return $this;
	}

	public function setMethod(PhpMethod $method) {
		$method->setParent($this);
		$this->methods[$method->getName()] = $method;
		
		return $this;
	}

	public function getMethod($method) {
		if (!isset($this->methods[$method])) {
			throw new \InvalidArgumentException(sprintf('The method "%s" does not exist.', $method));
		}
		
		return $this->methods[$method];
	}

	/**
	 *
	 * @param string|PhpMethod $method        	
	 */
	public function hasMethod($method) {
		if ($method instanceof PhpMethod) {
			$method = $method->getName();
		}
		
		return isset($this->methods[$method]);
	}

	/**
	 *
	 * @param string|PhpMethod $method        	
	 */
	public function removeMethod($method) {
		if ($method instanceof PhpMethod) {
			$method = $method->getName();
		}
		
		if (!array_key_exists($method, $this->methods)) {
			throw new \InvalidArgumentException(sprintf('The method "%s" does not exist.', $method));
		}
		$m = $this->methods[$method];
		$m->setParent(null);
		unset($this->methods[$method]);
		
		return $this;
	}

	public function getRequiredFiles() {
		return $this->requiredFiles;
	}

	public function getUseStatements() {
		return $this->useStatements;
	}

	public function getMethods() {
		return $this->methods;
	}

	public function generateDocblock() {
		$docblock = $this->getDocblock();
		$docblock->setShortDescription($this->getDescription());
		$docblock->setLongDescription($this->getLongDescription());
		
		foreach ($this->methods as $method) {
			$method->generateDocblock();
		}
	}
}
