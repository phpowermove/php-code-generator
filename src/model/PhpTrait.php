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
		
		if (null === self::$phpParser) {
			self::$phpParser = new PhpParser();
		}
		$trait->setUseStatements(self::$phpParser->parseClass($ref));

		if ($ref->getDocComment()) {
			$docblock = new Docblock($ref);
			$trait->setDocblock($docblock);
			$trait->setDescription($docblock->getShortDescription());
			$trait->setLongDescription($docblock->getLongDescription());
		}
		
		// traits
		foreach ($ref->getTraits() as $trait) {
			$trait->addTrait(PhpTrait::fromReflection($trait));
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
		
// 		$this->setDocblock($docblock);
		
// 		return $docblock;
	}
}