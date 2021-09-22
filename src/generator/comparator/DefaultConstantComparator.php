<?php
declare(strict_types=1);

namespace phpowermove\codegen\generator\comparator;

use phpowermove\codegen\model\PhpConstant;
use phootwork\lang\Comparator;

/**
 * Default property comparator
 *
 * Orders them by lower cased first, then upper cased
 */
class DefaultConstantComparator implements Comparator {

	private $comparator;

	public function __construct() {
		$this->comparator = new DefaultUseStatementComparator();
	}

	/**
	 * @param PhpConstant $a
	 * @param PhpConstant $b
	 */
	public function compare($a, $b) {
		return $this->comparator->compare($a->getName(), $b->getName());
	}

}
