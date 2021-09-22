<?php
declare(strict_types=1);

namespace phpowermove\codegen\model;

use phpowermove\codegen\model\parts\ConstantsPart;
use phpowermove\codegen\model\parts\InterfacesPart;
use phpowermove\codegen\parser\FileParser;
use phpowermove\codegen\parser\visitor\ConstantParserVisitor;
use phpowermove\codegen\parser\visitor\InterfaceParserVisitor;
use phpowermove\codegen\parser\visitor\MethodParserVisitor;

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
	public static function fromFile(string $filename): self {
		$interface = new self();
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
	public function generateDocblock(): void {
		parent::generateDocblock();

		foreach ($this->constants as $constant) {
			$constant->generateDocblock();
		}
	}
}
