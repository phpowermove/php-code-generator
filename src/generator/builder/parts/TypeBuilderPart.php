<?php
declare(strict_types=1);

namespace gossi\codegen\generator\builder\parts;

use gossi\codegen\model\AbstractModel;
use gossi\codegen\model\parts\TypePart;

trait TypeBuilderPart {

	public static $noTypeHints = [
		'string', 'int', 'integer', 'bool', 'boolean', 'float', 'double', 'object', 'mixed', 'resource'
	];

    public static $php7typeHints = [
		'string', 'int', 'integer', 'bool', 'boolean', 'float', 'double'
	];

	protected static $typeHintMap = [
		'string' => 'string',
		'int' => 'int',
		'integer' => 'int',
		'bool' => 'bool',
		'boolean' => 'bool',
		'float' => 'float',
		'double' => 'float'
	];

	/**
	 *
	 * @param AbstractModel|TypePart $model
	 * @param bool $allowed
	 *
	 * @return string|null
	 */
	private function getType(AbstractModel $model, bool $allowed, bool $nullable): ?string {
		$types = $model->getTypes();
		if ($types && count($types) === 1
				&& (!in_array($types[0], self::$noTypeHints, true)
					|| ($allowed && in_array($types[0], self::$php7typeHints, true)))
				) {

            $type = self::$typeHintMap[$types[0]] ?? $types[0];

            if ($nullable && $model->getNullable()) {
				$type = '?' . $type;
			}

			return $type;
		}

		return null;
	}
}
