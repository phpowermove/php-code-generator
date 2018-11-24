<?php
declare(strict_types=1);

namespace gossi\codegen\generator\builder;

use gossi\codegen\model\AbstractModel;
use gossi\codegen\generator\builder\parts\ValueBuilderPart;

class PropertyBuilder extends AbstractBuilder {

	use ValueBuilderPart;

	public function build(AbstractModel $model): void {
		$this->buildDocblock($model);

		$this->writer->write($model->getVisibility() . ' ');
		$this->writer->write($model->isStatic() ? 'static ' : '');
		$this->writer->write('$' . $model->getName());

		if ($model->hasValue()) {
			$this->writer->write(' = ');
			$this->writeValue($model);
		}

		$this->writer->writeln(';');
	}

}