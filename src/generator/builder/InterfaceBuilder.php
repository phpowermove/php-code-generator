<?php
declare(strict_types=1);

namespace phpowermove\codegen\generator\builder;

use phpowermove\codegen\generator\builder\parts\StructBuilderPart;
use phpowermove\codegen\model\AbstractModel;
use phpowermove\codegen\model\PhpInterface;

class InterfaceBuilder extends AbstractBuilder {

	use StructBuilderPart;

	public function build(AbstractModel $model): void {
		$this->sort($model);

		$this->buildHeader($model);

		// signature
		$this->buildSignature($model);

		// body
		$this->writer->writeln(" {\n")->indent();
		$this->buildConstants($model);
		$this->buildMethods($model);
		$this->writer->outdent()->rtrim()->write('}');
	}

	private function buildSignature(PhpInterface $model) {
		$this->writer->write('interface ');
		$this->writer->write($model->getName());

		if ($model->hasInterfaces()) {
			$this->writer->write(' extends ');
			$this->writer->write(implode(', ', $model->getInterfaces()->toArray()));
		}
	}

	private function sort(PhpInterface $model) {
		$this->sortUseStatements($model);
		$this->sortConstants($model);
		$this->sortMethods($model);
	}
}
