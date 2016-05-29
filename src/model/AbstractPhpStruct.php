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

use gossi\codegen\model\parts\DocblockPart;
use gossi\codegen\model\parts\LongDescriptionPart;
use gossi\codegen\model\parts\QualifiedNamePart;
use gossi\docblock\Docblock;

/**
 * Represents an abstract php structure (class, trait or interface).
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 * @author Thomas Gossmann
 */
abstract class AbstractPhpStruct extends AbstractModel implements NamespaceInterface, DocblockInterface {

	use DocblockPart;
	use LongDescriptionPart;
	use QualifiedNamePart;

	/** @var array */
	private $useStatements = [];

	/** @var array */
	private $requiredFiles = [];

	/** @var PhpMethod[] */
	private $methods = [];

	/**
	 * Creates a new struct
	 *
	 * @param string $name the fqcn
	 * @return static
	 */
	public static function create($name = null) {
		return new static($name);
	}

	/**
	 * Creates a method from reflection
	 *
	 * @return PhpMethod
	 */
	protected static function createMethod(\ReflectionMethod $method) {
		return PhpMethod::fromReflection($method);
	}

	/**
	 * Creates a property from reflection
	 *
	 * @return PhpProperty
	 */
	protected static function createProperty(\ReflectionProperty $property) {
		return PhpProperty::fromReflection($property);
	}

	/**
	 * Creates a new struct
	 *
	 * @param string $name the fqcn
	 */
	public function __construct($name = null) {
		$this->setQualifiedName($name);
		$this->docblock = new Docblock();
	}

	/**
	 * Sets requried files
	 *
	 * @param array $files
	 * @return $this
	 */
	public function setRequiredFiles(array $files) {
		$this->requiredFiles = $files;

		return $this;
	}

	/**
	 * Adds a new required file
	 *
	 * @param string $file
	 * @return $this
	 */
	public function addRequiredFile($file) {
		$this->requiredFiles[] = $file;

		return $this;
	}

	/**
	 * Returns required files
	 *
	 * @return array collection of filenames
	 */
	public function getRequiredFiles() {
		return $this->requiredFiles;
	}

	/**
	 * Sets use statements
	 *
	 * @see #addUseStatement
	 * @see #declareUses()
	 * @param array $useStatements
	 * @return $this
	 */
	public function setUseStatements(array $useStatements) {
		$this->useStatements = [];
		foreach ($useStatements as $alias => $useStatement) {
			$this->addUseStatement($useStatement, $alias);
		}

		return $this;
	}

	/**
	 * Adds a use statement with an optional alias
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
	 * Declares multiple use statements at once.
	 *
	 * @param ... use statements multiple qualified names
	 * @return $this
	 */
	public function declareUses() {
		foreach (func_get_args() as $name) {
			$this->declareUse($name);
		}
		return $this;
	}

	/**
	 * Declares a "use $fullClassName" with " as $alias" if $alias is available,
	 * and returns its alias (or not qualified classname) to be used in your actual
	 * php code.
	 *
	 * If the class has already been declared you get only the set alias.
	 *
	 * @param string $qualifiedName
	 * @param null|string $alias
	 * @return string the used alias
	 */
	public function declareUse($qualifiedName, $alias = null) {
		$qualifiedName = trim($qualifiedName, '\\');
		if (!$this->hasUseStatement($qualifiedName)) {
		$this->addUseStatement($qualifiedName, $alias);
		}
		return $this->getUseAlias($qualifiedName);
	}

	/**
	 * Returns whether the given use statement is present
	 *
	 * @param string $qualifiedName
	 * @return bool
	 */
	public function hasUseStatement($qualifiedName) {
		$flipped = array_flip($this->useStatements);
		return isset($flipped[$qualifiedName]);
	}

	/**
	 * Returns the usable alias for a qualified name
	 *
	 * @param string $qualifiedName
	 * @return string the alias
	 */
	public function getUseAlias($qualifiedName) {
		$flipped = array_flip($this->useStatements);
		return $flipped[$qualifiedName];
	}

	/**
	 * Removes a use statement
	 *
	 * @param string $qualifiedName
	 * @return $this
	 */
	public function removeUseStatement($qualifiedName) {
		$offset = array_search($qualifiedName, $this->useStatements);
		if ($offset !== null) {
			unset($this->useStatements[$offset]);
		}
		return $this;
	}

	/**
	 * Returns all use statements
	 *
	 * @return array collection of use statements
	 */
	public function getUseStatements() {
		return $this->useStatements;
	}

	/**
	 * Sets a collection of methods
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

	/**
	 * Adds a method
	 *
	 * @param PhpMethod $method
	 * @return $this
	 */
	public function setMethod(PhpMethod $method) {
		$method->setParent($this);
		$this->methods[$method->getName()] = $method;

		return $this;
	}

	/**
	 * Removes a method
	 *
	 * @param string|PhpMethod $nameOrMethod method name or Method instance
	 * @throws \InvalidArgumentException if the method cannot be found
	 * @return $this
	 */
	public function removeMethod($nameOrMethod) {
		if ($nameOrMethod instanceof PhpMethod) {
			$nameOrMethod = $nameOrMethod->getName();
		}

		if (!array_key_exists($nameOrMethod, $this->methods)) {
			throw new \InvalidArgumentException(sprintf('The method "%s" does not exist.', $nameOrMethod));
		}
		$m = $this->methods[$nameOrMethod];
		$m->setParent(null);
		unset($this->methods[$nameOrMethod]);

		return $this;
	}

	/**
	 * Checks whether a method exists or not
	 *
	 * @param string|PhpMethod $nameOrMethod method name or Method instance
	 * @return bool `true` if it exists and `false` if not
	 */
	public function hasMethod($nameOrMethod) {
		if ($nameOrMethod instanceof PhpMethod) {
			$nameOrMethod = $nameOrMethod->getName();
		}

		return isset($this->methods[$nameOrMethod]);
	}

	/**
	 * Returns a method
	 *
	 * @param string $nameOrMethod the methods name
	 * @throws \InvalidArgumentException if the method cannot be found
	 * @return PhpMethod
	 */
	public function getMethod($nameOrMethod) {
		if ($nameOrMethod instanceof PhpMethod) {
			$nameOrMethod = $nameOrMethod->getName();
		}

		if (!isset($this->methods[$nameOrMethod])) {
			throw new \InvalidArgumentException(sprintf('The method "%s" does not exist.', $nameOrMethod));
		}

		return $this->methods[$nameOrMethod];
	}

	/**
	 * Returns all methods
	 *
	 * @return PhpMethod[] collection of methods
	 */
	public function getMethods() {
		return $this->methods;
	}

	/**
	 * Returns all method names
	 *
	 * @return string[]
	 */
	public function getMethodNames() {
		return array_keys($this->methods);
	}

	/**
	 * Clears all methods
	 *
	 * @return $this
	 */
	public function clearMethods() {
		foreach ($this->methods as $method) {
			$method->setParent(null);
		}
		$this->methods = [];

		return $this;
	}

	/**
	 * Generates a docblock from provided information
	 *
	 * @return $this
	 */
	public function generateDocblock() {
		$docblock = $this->getDocblock();
		$docblock->setShortDescription($this->getDescription());
		$docblock->setLongDescription($this->getLongDescription());

		foreach ($this->methods as $method) {
			$method->generateDocblock();
		}

		return $this;
	}
}
