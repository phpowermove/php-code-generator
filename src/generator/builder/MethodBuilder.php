<?php
declare(strict_types=1);

namespace gossi\codegen\generator\builder;

use gossi\codegen\generator\builder\parts\RoutineBuilderPart;
use gossi\codegen\model\AbstractModel;
use gossi\codegen\model\PhpInterface;

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