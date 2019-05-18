<?php
declare(strict_types=1);

namespace gossi\codegen\generator\builder\parts;

use gossi\codegen\model\PhpConstant;
use gossi\codegen\model\ValueInterface;

trait ValueBuilderPart {

	private function writeValue(ValueInterface $model): void {
		if ($model->isExpression()) {
			$this->writer->write($model->getExpression());
		} else {
			$value = $model->getValue();

			if ($value instanceof PhpConstant) {
				$this->writer->write($value->getName());
			} else {
				$this->writer->write($this->exportVar($value));
			}
		}
	}

	private function exportVar($value) {
		// Simply to be sure a null value is displayed in lowercase.
		if (is_null($value)) {
			return 'null';
		}

		return var_export($value, true);
	}
}
