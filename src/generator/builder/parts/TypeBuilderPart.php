<?php
declare(strict_types=1);

namespace phpowermove\codegen\generator\builder\parts;

use phpowermove\codegen\model\AbstractModel;

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
	 * @param AbstractModel $model
	 * @param bool $allowed
	 * @return string|null
	 */
	private function getType(AbstractModel $model, bool $allowed, bool $nullable): ?string {
		$type = $model->getType();
		if (!empty($type) && strpos($type, '|') === false
				&& (!in_array($type, self::$noTypeHints)
					|| ($allowed && in_array($type, self::$php7typeHints)))
				) {

			$type = isset(self::$typeHintMap[$type])
				? self::$typeHintMap[$type]
				: $type;

			if ($nullable && $model->getNullable()) {
				$type = '?' . $type;
			}

			return $type;
		}

		return null;
	}
}
