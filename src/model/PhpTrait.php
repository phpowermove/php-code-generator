<?php
declare(strict_types=1);

namespace phpowermove\codegen\model;

use phpowermove\codegen\model\parts\PropertiesPart;
use phpowermove\codegen\model\parts\TraitsPart;
use phpowermove\codegen\parser\FileParser;
use phpowermove\codegen\parser\visitor\ConstantParserVisitor;
use phpowermove\codegen\parser\visitor\MethodParserVisitor;
use phpowermove\codegen\parser\visitor\PropertyParserVisitor;
use phpowermove\codegen\parser\visitor\TraitParserVisitor;

/**
 * Represents a PHP trait.
 *
 * @author Thomas Gossmann
 */
class PhpTrait extends AbstractPhpStruct implements GenerateableInterface, TraitsInterface, PropertiesInterface {

	use PropertiesPart;
	use TraitsPart;

	/**
	 * Creates a PHP trait from a file
	 *
	 * @param string $filename
	 * @return PhpTrait
	 */
	public static function fromFile(string $filename): self {
		$trait = new self();
		$parser = new FileParser($filename);
		$parser->addVisitor(new TraitParserVisitor($trait));
		$parser->addVisitor(new MethodParserVisitor($trait));
		$parser->addVisitor(new ConstantParserVisitor($trait));
		$parser->addVisitor(new PropertyParserVisitor($trait));
		$parser->parse();

		return $trait;
	}

	/**
	 * Creates a new PHP trait
	 *
	 * @param string $name qualified name
	 */
	public function __construct($name = null) {
		parent::__construct($name);
		$this->initProperties();
	}

	/**
	 * @inheritDoc
	 */
	public function generateDocblock(): void {
		parent::generateDocblock();

		foreach ($this->properties as $prop) {
			$prop->generateDocblock();
		}
	}
}
