<?php
declare(strict_types=1);

namespace phpowermove\codegen\generator\builder;

use phpowermove\codegen\generator\builder\parts\TypeBuilderPart;
use phpowermove\codegen\generator\builder\parts\ValueBuilderPart;
use phpowermove\codegen\model\AbstractModel;

class ParameterBuilder extends AbstractBuilder {

	use ValueBuilderPart;
	use TypeBuilderPart;

	public function build(AbstractModel $model): void {
		$type = $this->getType($model, $this->config->getGenerateScalarTypeHints(), $this->config->getGenerateNullableTypes());
		if ($type !== null) {
			$this->writer->write($type . ' ');
		}

		if ($model->isPassedByReference()) {
			$this->writer->write('&');
		}

		$this->writer->write('$' . $model->getName());

		if ($model->hasValue()) {
			$this->writer->write(' = ');

			$this->writeValue($model);
		}
	}

}
