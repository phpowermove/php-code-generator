<?php
declare(strict_types=1);

namespace gossi\codegen\generator\builder\parts;

use gossi\codegen\model\AbstractModel;
use gossi\codegen\model\parts\TypePart;

trait TypeBuilderPart {

	protected static $noTypeHints = [
		'string', 'int', 'integer', 'bool', 'boolean', 'float', 'double', 'object', 'mixed', 'resource'
	];

    protected static $php7typeHints = [
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
		if (!$types || $types->size() !== 1) {
		    return null;
        }
		$type = (string)$types->values()->toArray()[0];
		if (!in_array($type, self::$noTypeHints, true)
            || ($allowed && in_array($type, self::$php7typeHints, true))) {

            $type = self::$typeHintMap[$type] ?? $type;

            if ($nullable && $model->getNullable()) {
				$type = '?' . $type;
			}

			return $type;
		}

		return null;
	}
}
