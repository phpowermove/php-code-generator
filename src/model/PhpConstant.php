<?php
namespace gossi\codegen\model;

use gossi\codegen\model\parts\DocblockPart;
use gossi\codegen\model\parts\LongDescriptionPart;
use gossi\codegen\model\parts\NamePart;
use gossi\codegen\model\parts\TypeDocblockGeneratorPart;
use gossi\codegen\model\parts\TypePart;
use gossi\codegen\model\parts\ValuePart;
use gossi\docblock\Docblock;
use gossi\docblock\tags\VarTag;

/**
 * Represents a PHP constant.
 *
 * @author Thomas Gossmann
 */
class PhpConstant extends AbstractModel implements GenerateableInterface, DocblockInterface {

	use DocblockPart;
	use LongDescriptionPart;
	use NamePart;
	use TypeDocblockGeneratorPart;
	use TypePart;
	use ValuePart;

	/**
	 * Creates a new PHP constant
	 *
	 * @param string $name
	 * @param mixed $value
	 * @param bool $isExpression
	 * @return static
	 */
	public static function create($name = null, $value = null, $isExpression = false) {
		$constant = new static($name, $value, $isExpression);
// 		$constant->setName($name);

// 		if (is_string($value)) {
// 			$constant->setValue($value);
// 		} else {
// 			$constant->setExpression($value);
// 		}

		return $constant;
	}

	/**
	 * Creates a new PHP constant
	 *
	 * @param string $name
	 * @param mixed $value
	 * @param bool $isExpression
	 */
	public function __construct($name = null, $value = null, $isExpression = false) {
		$this->setName($name);

		if ($isExpression) {
			$this->setExpression($value);
		} else {
			$this->setValue($value);
		}
		$this->docblock = new Docblock();
	}

	/**
	 * @inheritDoc
	 */
	public function generateDocblock() {
		$docblock = $this->getDocblock();
		$docblock->setShortDescription($this->getDescription());
		$docblock->setLongDescription($this->getLongDescription());

		// var tag
		$this->generateTypeTag(new VarTag());
	}
}
