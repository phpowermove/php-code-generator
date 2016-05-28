<?php
namespace gossi\codegen\model;

use gossi\docblock\Docblock;
use gossi\docblock\tags\VarTag;
use gossi\codegen\model\parts\NameTrait;
use gossi\codegen\model\parts\LongDescriptionTrait;
use gossi\codegen\model\parts\DocblockTrait;
use gossi\codegen\model\parts\TypeTrait;
use gossi\codegen\model\parts\TypeDocblockGeneratorTrait;
use gossi\codegen\model\parts\ValueTrait;

/**
 * Represents a PHP constant.
 * 
 * @author gossi
 */
class PhpConstant extends AbstractModel implements GenerateableInterface, DocblockInterface {

	use NameTrait;
	use LongDescriptionTrait;
	use DocblockTrait;
	use TypeTrait;
	use TypeDocblockGeneratorTrait;
	use ValueTrait;

	public static function create($name = null, $value = null) {
		$constant = new static();
		$constant->setName($name)->setValue($value);

		return $constant;
	}

	public function __construct($name = null, $value = null) {
		$this->setName($name);
		$this->setValue($value);
		$this->docblock = new Docblock();
	}

	public function generateDocblock() {
		$docblock = $this->getDocblock();
		$docblock->setShortDescription($this->getDescription());
		$docblock->setLongDescription($this->getLongDescription());

		// var tag
		$this->generateTypeTag(new VarTag());
	}
}