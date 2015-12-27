<?php
namespace gossi\codegen\model;

use gossi\codegen\model\parts\ConstantsTrait;
use gossi\codegen\model\parts\InterfacesTrait;
use gossi\codegen\parser\FileParser;
use gossi\codegen\parser\visitor\PhpInterfaceVisitor;
use gossi\codegen\utils\ReflectionUtils;
use gossi\docblock\Docblock;

class PhpInterface extends AbstractPhpStruct implements GenerateableInterface, ConstantsInterface {
	
	use InterfacesTrait;
	use ConstantsTrait;

	/**
	 * Creates an interface from reflection
	 * 
	 * @param \ReflectionClass $ref
	 * @return PhpInterface
	 */
	public static function fromReflection(\ReflectionClass $ref) {
		$interface = new static();
		$interface->setQualifiedName($ref->name)
			->setConstants($ref->getConstants())
			->setUseStatements(ReflectionUtils::getUseStatements($ref));
		
		$docblock = new Docblock($ref);
		$interface->setDocblock($docblock);
		$interface->setDescription($docblock->getShortDescription());
		$interface->setLongDescription($docblock->getLongDescription());
		
		foreach ($ref->getMethods() as $method) {
			$method = static::createMethod($method);
			$method->setAbstract(false);
			$interface->setMethod($method);
		}
		
		return $interface;
	}
	
	/**
	 * Creates an interface from file 
	 * 
	 * @param string $filename
	 * @return PhpInterface
	 */
	public static function fromFile($filename) {
		$visitor = new PhpInterfaceVisitor();
		$parser = new FileParser();
		return $parser->parse($visitor, $filename);
	}

	public function __construct($name = null) {
		parent::__construct($name);
	}

	public function generateDocblock() {
		parent::generateDocblock();
		
		foreach ($this->constants as $constant) {
			$constant->generateDocblock();
		}
	}
}