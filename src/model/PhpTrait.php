<?php
namespace gossi\codegen\model;

use gossi\docblock\Docblock;
use gossi\codegen\model\parts\PropertiesTrait;
use gossi\codegen\model\parts\TraitsTrait;
use Doctrine\Common\Annotations\PhpParser;

class PhpTrait extends AbstractPhpStruct implements GenerateableInterface, TraitsInterface {
	
	use PropertiesTrait;
	use TraitsTrait;

	public static function fromReflection(\ReflectionClass $ref) {
		$trait = new static();
		$trait->setQualifiedName($ref->name);
		$trait->setUseStatements(static::getUseStatementsFromReflection($ref));

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