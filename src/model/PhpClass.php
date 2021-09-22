<?php
declare(strict_types=1);

namespace phpowermove\codegen\model;

use phpowermove\codegen\model\parts\AbstractPart;
use phpowermove\codegen\model\parts\ConstantsPart;
use phpowermove\codegen\model\parts\FinalPart;
use phpowermove\codegen\model\parts\InterfacesPart;
use phpowermove\codegen\model\parts\PropertiesPart;
use phpowermove\codegen\model\parts\TraitsPart;
use phpowermove\codegen\parser\FileParser;
use phpowermove\codegen\parser\visitor\ClassParserVisitor;
use phpowermove\codegen\parser\visitor\ConstantParserVisitor;
use phpowermove\codegen\parser\visitor\MethodParserVisitor;
use phpowermove\codegen\parser\visitor\PropertyParserVisitor;

/**
 * Represents a PHP class.
 *
 * @author Thomas Gossmann
 */
class PhpClass extends AbstractPhpStruct implements GenerateableInterface, TraitsInterface, ConstantsInterface, PropertiesInterface {

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

	/**
	 * Sets the parent class name
	 *
	 * @param string|null $name the new parent
	 * @return $this
	 */
	public function setParentClassName(?string $name) {
		$this->parentClassName = $name;

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
