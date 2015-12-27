<?php
namespace gossi\codegen\model;

use gossi\codegen\model\parts\AbstractTrait;
use gossi\codegen\model\parts\ConstantsTrait;
use gossi\codegen\model\parts\FinalTrait;
use gossi\codegen\model\parts\InterfacesTrait;
use gossi\codegen\model\parts\PropertiesTrait;
use gossi\codegen\model\parts\TraitsTrait;
use gossi\codegen\parser\FileParser;
use gossi\codegen\parser\visitor\PhpClassVisitor;
use gossi\codegen\utils\ReflectionUtils;
use gossi\docblock\Docblock;

class PhpClass extends AbstractPhpStruct implements GenerateableInterface, TraitsInterface, ConstantsInterface {
	
	use InterfacesTrait;
	use AbstractTrait;
	use FinalTrait;
	use ConstantsTrait;
	use PropertiesTrait;
	use TraitsTrait;

	private $parentClassName;

	/**
	 * Creates a class from reflection
	 * 
	 * @param \ReflectionClass $ref
	 * @return PhpClass
	 */
	public static function fromReflection(\ReflectionClass $ref) {
		$class = new static();
		$class->setQualifiedName($ref->name)
			->setAbstract($ref->isAbstract())
			->setFinal($ref->isFinal())
			->setConstants($ref->getConstants())
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
		$class->setConstants($ref->getConstants());

		return $class;
	}
	
	/**
	 * Creates a class from file
	 * 
	 * @param string $filename
	 * @return PhpClass
	 */
	public static function fromFile($filename) {
		$visitor = new PhpClassVisitor();
		$parser = new FileParser();
		return $parser->parse($visitor, $filename);
	}

	public function __construct($name = null) {
		parent::__construct($name);
	}

	public function getParentClassName() {
		return $this->parentClassName;
	}

	/**
	 *
	 * @param string|null $name        	
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
