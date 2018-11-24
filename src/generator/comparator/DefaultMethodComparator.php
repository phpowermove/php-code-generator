<?php
declare(strict_types=1);

namespace gossi\codegen\generator\comparator;

use gossi\codegen\model\PhpMethod;
use phootwork\lang\Comparator;

/**
 * Default property comparator
 *
 * Orders them by static first, then visibility and last by property name
 */
class DefaultMethodComparator implements Comparator {

	/**
	 * @param PhpMethod $a
	 * @param PhpMethod $b
	 */
	public function compare($a, $b) {
		if ($a->isStatic() !== $isStatic = $b->isStatic()) {
			return $isStatic ? 1 : -1;
		}

		if (($aV = $a->getVisibility()) !== $bV = $b->getVisibility()) {
			$aV = 'public' === $aV ? 3 : ('protected' === $aV ? 2 : 1);
			$bV = 'public' === $bV ? 3 : ('protected' === $bV ? 2 : 1);

			return $aV > $bV ? -1 : 1;
		}

		return strcasecmp($a->getName(), $b->getName());
	}

}