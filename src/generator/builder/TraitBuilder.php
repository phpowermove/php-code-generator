<?php
declare(strict_types=1);

namespace gossi\codegen\generator\builder;

use gossi\codegen\generator\builder\parts\StructBuilderPart;
use gossi\codegen\model\AbstractModel;
use gossi\codegen\model\PhpTrait;

class TraitBuilder extends AbstractBuilder {

	use StructBuilderPart;

	public function build(AbstractModel $model): void {
		$this->sort($model);

		$this->buildHeader($model);

		// signature
		$this->buildSignature($model);

		// body
		$this->writer->writeln(" {\n")->indent();
		$this->buildTraits($model);
		$this->buildProperties($model);
		$this->buildMethods($model);
		$this->writer->outdent()->rtrim()->write('}');
	}

	private function buildSignature(PhpTrait $model) {
		$this->writer->write('trait ');
		$this->writer->write($model->getName());
	}

	private function sort(PhpTrait $model) {
		$this->sortUseStatements($model);
		$this->sortProperties($model);
		$this->sortMethods($model);
	}
}
