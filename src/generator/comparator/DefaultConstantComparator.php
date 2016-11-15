<?php
namespace gossi\codegen\generator\comparator;

use phootwork\lang\Comparator;
use gossi\codegen\model\PhpConstant;

class DefaultConstantComparator implements Comparator {

	/**
	 * @param PhpConstant $a
	 * @param PhpConstant $b
	 */
	public function compare($a, $b) {
		return strcasecmp($a->getName(), $b->getName());
	}

}