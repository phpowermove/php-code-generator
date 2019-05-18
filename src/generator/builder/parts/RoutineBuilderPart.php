<?php
declare(strict_types=1);

namespace gossi\codegen\generator\builder\parts;

use gossi\codegen\model\AbstractModel;
use gossi\codegen\model\RoutineInterface;

Trait RoutineBuilderPart {

	use TypeBuilderPart;

	/**
	 * @param AbstractModel $model
	 * @return void
	 */
	protected abstract function generate(AbstractModel $model): void;

	protected function writeFunctionStatement(RoutineInterface $model): void {
		$this->writer->write('function ');

		if ($model->isReferenceReturned()) {
			$this->writer->write('& ');
		}

		$this->writer->write($model->getName() . '(');
		$this->writeParameters($model);
		$this->writer->write(')');
		$this->writeFunctionReturnType($model);
	}

	protected function writeParameters(RoutineInterface $model): void {
		$first = true;
		foreach ($model->getParameters() as $parameter) {
			if (!$first) {
				$this->writer->write(', ');
			}
			$first = false;

			$this->generate($parameter);
		}
	}

	protected function writeFunctionReturnType(RoutineInterface $model): void {
		$type = $this->getType($model, $this->config->getGenerateReturnTypeHints(), $this->config->getGenerateNullableTypes());
		if ($type !== null && $this->config->getGenerateReturnTypeHints()) {
			$this->writer->write(': ')->write($type);
		}
	}

	protected function writeBody(RoutineInterface $model): void {
		$this->writer->writeln(' {')->indent();
		$this->writer->writeln(trim($model->getBody()));
		$this->writer->outdent()->rtrim()->writeln('}');
	}
}
