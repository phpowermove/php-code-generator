<?php
declare(strict_types=1);

namespace phpowermove\codegen\generator\builder;

use phpowermove\codegen\generator\builder\parts\RoutineBuilderPart;
use phpowermove\codegen\model\AbstractModel;
use phpowermove\codegen\model\PhpInterface;

class MethodBuilder extends AbstractBuilder {

	use RoutineBuilderPart;

	public function build(AbstractModel $model): void {
		$this->buildDocblock($model);

		if ($model->isFinal()) {
			$this->writer->write('final ');
		}

		if ($model->isAbstract()) {
			$this->writer->write('abstract ');
		}

		$this->writer->write($model->getVisibility() . ' ');

		if ($model->isStatic()) {
			$this->writer->write('static ');
		}

		$this->writeFunctionStatement($model);

		if ($model->isAbstract() || $model->getParent() instanceof PhpInterface) {
			$this->writer->writeln(';');

			return;
		}

		$this->writeBody($model);
	}

}
