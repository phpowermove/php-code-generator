<?php
declare(strict_types=1);

namespace gossi\codegen\model;

use gossi\codegen\model\parts\AbstractPart;
use gossi\codegen\model\parts\ConstantsPart;
use gossi\codegen\model\parts\FinalPart;
use gossi\codegen\model\parts\InterfacesPart;
use gossi\codegen\model\parts\PropertiesPart;
use gossi\codegen\model\parts\TraitsPart;
use gossi\codegen\parser\FileParser;
use gossi\codegen\parser\visitor\ClassParserVisitor;
use gossi\codegen\parser\visitor\ConstantParserVisitor;
use gossi\codegen\parser\visitor\MethodParserVisitor;
use gossi\codegen\parser\visitor\PropertyParserVisitor;

/**
 * Represents a PHP class.
 *
 * @author Thomas Gossmann
 */
class PhpClass extends AbstractPhpStruct implements GenerateableInterface, TraitsInterface, ConstantsInterface, PropertiesInterface, PhpTypeInterface {

	use AbstractPart;
	use ConstantsPart;
	use FinalPart;
	use InterfacesPart;
	use PropertiesPart;
	use TraitsPart;

	/** @var string */
	private $parentClassName;

	/**
	 * Creates a PHP class from file
	 *
	 * @param string $filename
	 * @return PhpClass
	 */
	public static function fromFile(string $filename): self {
		$class = new self();
		$parser = new FileParser($filename);
		$parser->addVisitor(new ClassParserVisitor($class));
		$parser->addVisitor(new MethodParserVisitor($class));
		$parser->addVisitor(new ConstantParserVisitor($class));
		$parser->addVisitor(new PropertyParserVisitor($class));
		$parser->parse();

		return $class;
	}

	/**
	 * Creates a new PHP class
	 *
	 * @param string $name the qualified name
	 */
	public function __construct($name = null) {
		parent::__construct($name);
		$this->initProperties();
		$this->initConstants();
		$this->initInterfaces();
	}

	/**
	 * Returns the parent class name
	 *
	 * @return string
	 */
	public function getParentClassName(): ?string {
		return $this->parentClassName;
	}

    public function getParentClass(): PhpClass {
	    return class_exists($this->parentClassName) ?
            self::fromName($this->parentClassName) : PhpClass::create($this->parentClassName);
    }

	/**
	 * Sets the parent class name
	 *
	 * @param PhpClass|string|null $name the new parent
	 * @return $this
	 */
	public function setParentClassName($parent) {
		if ($parent instanceof PhpClass) {
		    $this->addUseStatement($parent->getQualifiedName());
		    $parent = $parent->getName();
        }
        $this->parentClassName = $parent;

        return $this;
	}

	public function generateDocblock(): void {
		parent::generateDocblock();

		foreach ($this->constants as $constant) {
			$constant->generateDocblock();
		}

		foreach ($this->properties as $prop) {
			$prop->generateDocblock();
		}
	}

}
