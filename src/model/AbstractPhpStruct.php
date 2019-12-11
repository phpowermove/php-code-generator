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

namespace gossi\codegen\model;

use gossi\codegen\model\parts\DocblockPart;
use gossi\codegen\model\parts\LongDescriptionPart;
use gossi\codegen\model\parts\QualifiedNamePart;
use gossi\codegen\utils\TypeUtils;
use gossi\docblock\Docblock;
use phootwork\collection\Map;
use phootwork\collection\Set;

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

	/** @var Map|string[] */
	private $useStatements;

	/** @var Set|string[] */
	private $requiredFiles;

	/** @var Map|PhpMethod[] */
	private $methods;

	/**
	 * Creates a new struct
	 *
	 * @param string $name the fqcn
	 * @return static
	 */
	public static function create(?string $name = null) {
		return new static($name);
	}

    public static function fromName(string $name): self
    {
        $ref = new \ReflectionClass($name);

        return static::fromFile($ref->getFileName());
    }

	/**
	 * Creates a new struct
	 *
	 * @param string $name the fqcn
	 */
	public function __construct(?string $name = null) {
		$this->setQualifiedName($name);
		$this->docblock = new Docblock();
		$this->useStatements = new Map();
		$this->requiredFiles = new Set();
		$this->methods = new Map();
	}

	/**
	 * Sets requried files
	 *
	 * @param array $files
	 * @return $this
	 */
	public function setRequiredFiles(array $files) {
		$this->requiredFiles = new Set($files);

		return $this;
	}

	/**
	 * Adds a new required file
	 *
	 * @param string $file
	 * @return $this
	 */
	public function addRequiredFile(string $file) {
		$this->requiredFiles->add($file);

		return $this;
	}

	/**
	 * Returns required files
	 *
	 * @return Set collection of filenames
	 */
	public function getRequiredFiles(): Set {
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
		$this->useStatements->clear();
		foreach ($useStatements as $alias => $useStatement) {
			$this->addUseStatement($useStatement, $alias);
		}

		return $this;
	}

	/**
	 * Adds a use statement with an optional alias
	 *
	 * @param string|PhpTypeInterface $qualifiedName
	 * @param null|string $alias
	 * @return $this
	 */
	public function addUseStatement($qualifiedName, string $alias = null) {
        if ($qualifiedName instanceof PhpTypeInterface) {
            $qualifiedName = $qualifiedName->getQualifiedName();
        }

        if (TypeUtils::isGlobalQualifiedName($qualifiedName) || TypeUtils::isNativeType($qualifiedName)) {
            return $this;
        }

	    if (preg_replace('#\\\\[^\\\\]+$#', '', $qualifiedName) === $this->getNamespace()) {
	        return $this;
        }

		if (!is_string($alias)) {
			if (false === strpos($qualifiedName, '\\')) {
				$alias = $qualifiedName;
			} else {
				$alias = substr($qualifiedName, strrpos($qualifiedName, '\\') + 1);
			}
		}

		$qualifiedName = str_replace('[]', '', $qualifiedName);
		$this->useStatements->set($alias, $qualifiedName);

		return $this;
	}

	/**
	 * Clears all use statements
	 *
	 * @return $this
	 */
	public function clearUseStatements() {
		$this->useStatements->clear();

		return $this;
	}

	/**
	 * Declares multiple use statements at once.
	 *
	 * @param ... use statements multiple qualified names
	 * @return $this
	 */
	public function declareUses(string ...$uses) {
		foreach ($uses as $name) {
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
	public function declareUse(string $qualifiedName, string $alias = null) {
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
	public function hasUseStatement(string $qualifiedName): bool {
		return $this->useStatements->contains($qualifiedName);
	}

	/**
	 * Returns the usable alias for a qualified name
	 *
	 * @param string $qualifiedName
	 * @return string the alias
	 */
	public function getUseAlias(string $qualifiedName): string {
		return $this->useStatements->getKey($qualifiedName);
	}

	/**
	 * Removes a use statement
	 *
	 * @param string $qualifiedName
	 * @return $this
	 */
	public function removeUseStatement(string $qualifiedName) {
		$this->useStatements->remove($this->useStatements->getKey($qualifiedName));
		return $this;
	}

	/**
	 * Returns all use statements
	 *
	 * @return Map collection of use statements
	 */
	public function getUseStatements(): Map {
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

		$this->methods->clear();
		foreach ($methods as $method) {
			$this->addMethod($method);
		}

		return $this;
	}

	/**
	 * Adds a method
	 *
	 * @param PhpMethod $method
	 * @return $this
	 */
	public function addMethod(PhpMethod $method) {
		$method->setParent($this);
		$this->methods->set($method->getName(), $method);
		$types = $method->getTypes();
        if ($types) {
            foreach ($types as $type) {
                $this->addUseStatement($type);
                $method->addType($type);
            }
        }

        foreach ($method->getParameters() as $parameter) {
            $types = $parameter->getTypes();
            if ($types) {
                foreach ($types as $type) {
                    $this->addUseStatement($type);
                    $parameter->addType($type);
                }
            }
        }

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

		if (!$this->methods->has($nameOrMethod)) {
			throw new \InvalidArgumentException(sprintf('The method "%s" does not exist.', $nameOrMethod));
		}
		$m = $this->methods->get($nameOrMethod);
		$m->setParent(null);
		$this->methods->remove($nameOrMethod);

		return $this;
	}

	/**
	 * Checks whether a method exists or not
	 *
	 * @param string|PhpMethod $nameOrMethod method name or Method instance
	 * @return bool `true` if it exists and `false` if not
	 */
	public function hasMethod($nameOrMethod): bool {
		if ($nameOrMethod instanceof PhpMethod) {
			$nameOrMethod = $nameOrMethod->getName();
		}

		return $this->methods->has($nameOrMethod);
	}

	/**
	 * Returns a method
	 *
	 * @param string $nameOrMethod the methods name
	 * @throws \InvalidArgumentException if the method cannot be found
	 * @return PhpMethod
	 */
	public function getMethod($nameOrMethod): PhpMethod {
		if ($nameOrMethod instanceof PhpMethod) {
			$nameOrMethod = $nameOrMethod->getName();
		}

		if (!$this->methods->has($nameOrMethod)) {
			throw new \InvalidArgumentException(sprintf('The method "%s" does not exist.', $nameOrMethod));
		}

		return $this->methods->get($nameOrMethod);
	}

	/**
	 * Returns all methods
	 *
	 * @return Map|PhpMethod[] collection of methods
	 */
	public function getMethods(): Map {
		return $this->methods;
	}

	/**
	 * Returns all method names
	 *
	 * @return Set
	 */
	public function getMethodNames(): Set {
		return $this->methods->keys();
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
		$this->methods->clear();

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
