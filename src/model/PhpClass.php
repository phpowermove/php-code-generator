<?php
namespace gossi\codegen\model;

use gossi\codegen\model\parts\AbstractPart;
use gossi\codegen\model\parts\ConstantsPart;
use gossi\codegen\model\parts\FinalPart;
use gossi\codegen\model\parts\InterfacesPart;
use gossi\codegen\model\parts\PropertiesPart;
use gossi\codegen\model\parts\TraitsPart;
use gossi\codegen\parser\FileParser;
use gossi\codegen\parser\visitor\PhpClassVisitor;
use gossi\codegen\utils\ReflectionUtils;
use gossi\docblock\Docblock;

/**
 * Represents a PHP class.
 *
 * @author Thomas Gossmann
 */
class PhpClass extends AbstractPhpStruct implements GenerateableInterface, TraitsInterface, ConstantsInterface {

	use AbstractPart;
	use ConstantsPart;
	use FinalPart;
	use InterfacesPart;
	use PropertiesPart;
	use TraitsPart;

	/** @var string */
	private $parentClassName;

	/**
	 * Creates a PHP class from reflection
	 *
	 * @param \ReflectionClass $ref
	 * @return PhpClass
	 */
	public static function fromReflection(\ReflectionClass $ref) {
		$class = new static();
		$class->setQualifiedName($ref->name)
			->setAbstract($ref->isAbstract())
			->setFinal($ref->isFinal())
			->setUseStatements(ReflectionUtils::getUseStatements($ref));

		if ($ref->getDocComment()) {
			$docblock = new Docblock($ref);
			$class->setDocblock($docblock);
			$class->setDescription($docblock->getShortDescription());
			$class->setLongDescription($docblock->getLongDescription());
		}

		// methods
		foreach ($ref->getMethods() as $method) {
			$class->setMethod(static::createMethod($method));
		}

		// properties
		foreach ($ref->getProperties() as $property) {
			$class->setProperty(static::createProperty($property));
		}

		// traits
		foreach ($ref->getTraits() as $trait) {
			$class->addTrait(PhpTrait::fromReflection($trait));
		}

		// constants
		// TODO: https://github.com/gossi/php-code-generator/issues/19
		$class->setConstants($ref->getConstants());

		return $class;
	}

	/**
	 * Creates a PHP class from file
	 *
	 * @param string $filename
	 * @return PhpClass
	 */
	public static function fromFile($filename) {
		$visitor = new PhpClassVisitor();
		$parser = new FileParser();
		return $parser->parse($visitor, $filename);
	}

	/**
	 * Creates a new PHP class
	 *
	 * @param string $name the qualified name
	 */
	public function __construct($name = null) {
		parent::__construct($name);
	}

	/**
	 * Returns the parent class name
	 *
	 * @return string
	 */
	public function getParentClassName() {
		return $this->parentClassName;
	}

	/**
	 * Sets the parent class name
	 *
	 * @param string|null $name the new parent
	 * @return $this
	 */
	public function setParentClassName($name) {
		$this->parentClassName = $name;

		return $this;
	}

	public function generateDocblock() {
		parent::generateDocblock();

		foreach ($this->constants as $constant) {
			$constant->generateDocblock();
		}

		foreach ($this->properties as $prop) {
			$prop->generateDocblock();
		}
	}

}
