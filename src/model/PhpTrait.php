<?php
namespace gossi\codegen\model;

use gossi\codegen\model\parts\PropertiesTrait;
use gossi\codegen\model\parts\TraitsTrait;
use gossi\codegen\parser\FileParser;
use gossi\codegen\parser\visitor\PhpTraitVisitor;
use gossi\codegen\utils\ReflectionUtils;
use gossi\docblock\Docblock;

/**
 * Represents a PHP trait.
 * 
 * @author gossi
 */
class PhpTrait extends AbstractPhpStruct implements GenerateableInterface, TraitsInterface {
	
	use PropertiesTrait;
	use TraitsTrait;

	/**
	 * Creates a PHP trait from reflection
	 * 
	 * @param \ReflectionClass $ref
	 * @return PhpTrait
	 */
	public static function fromReflection(\ReflectionClass $ref) {
		$trait = new static();
		$trait->setQualifiedName($ref->name);
		$trait->setUseStatements(ReflectionUtils::getUseStatements($ref));

		$docblock = new Docblock($ref);
		$trait->setDocblock($docblock);
		$trait->setDescription($docblock->getShortDescription());
		$trait->setLongDescription($docblock->getLongDescription());
		
		// traits
		foreach ($ref->getTraits() as $reflectionTrait) {
			$trait->addTrait(PhpTrait::fromReflection($reflectionTrait));
		}
		
		// properties
		foreach ($ref->getProperties() as $property) {
			$trait->setProperty(static::createProperty($property));
		}
		
		// methods
		foreach ($ref->getMethods() as $method) {
			$trait->setMethod(static::createMethod($method));
		}

		return $trait;
	}
	
	/**
	 * Creates a PHP trait from a file
	 * 
	 * @param string $filename
	 * @return PhpTrait
	 */
	public static function fromFile($filename) {
		$visitor = new PhpTraitVisitor();
		$parser = new FileParser();
		return $parser->parse($visitor, $filename);
	}

	/**
	 * Creates a new PHP trait
	 * 
	 * @param string $name qualified name
	 */
	public function __construct($name = null) {
		parent::__construct($name);
	}

	public function generateDocblock() {
		parent::generateDocblock();
		
		foreach ($this->properties as $prop) {
			$prop->generateDocblock();
		}
	}
}