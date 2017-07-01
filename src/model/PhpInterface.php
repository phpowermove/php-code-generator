<?php
namespace gossi\codegen\model;

use gossi\codegen\model\parts\ConstantsPart;
use gossi\codegen\model\parts\InterfacesPart;
use gossi\codegen\parser\FileParser;
use gossi\codegen\parser\visitor\ConstantParserVisitor;
use gossi\codegen\parser\visitor\InterfaceParserVisitor;
use gossi\codegen\parser\visitor\MethodParserVisitor;

/**
 * Represents a PHP interface.
 *
 * @author Thomas Gossmann
 */
class PhpInterface extends AbstractPhpStruct implements GenerateableInterface, ConstantsInterface {

	use ConstantsPart;
	use InterfacesPart;

	/**
	 * Creates a PHP interface from file
	 *
	 * @param string $filename
	 * @return PhpInterface
	 */
	public static function fromFile($filename) {
		$interface = new PhpInterface();
		$parser = new FileParser($filename);
		$parser->addVisitor(new InterfaceParserVisitor($interface));
		$parser->addVisitor(new MethodParserVisitor($interface));
		$parser->addVisitor(new ConstantParserVisitor($interface));
		$parser->parse();
		
		return $interface;
	}

	/**
	 * Create a new PHP interface
	 *
	 * @param string $name qualified name
	 */
	public function __construct($name = null) {
		parent::__construct($name);
		$this->initConstants();
		$this->initInterfaces();
	}

	/**
	 * @inheritDoc
	 */
	public function generateDocblock() {
		parent::generateDocblock();

		foreach ($this->constants as $constant) {
			$constant->generateDocblock();
		}
	}
}
