<?php
declare(strict_types=1);

namespace phpowermove\codegen\generator\builder;

use phpowermove\codegen\generator\builder\parts\RoutineBuilderPart;
use phpowermove\codegen\model\AbstractModel;

class FunctionBuilder extends AbstractBuilder {

	use RoutineBuilderPart;

	public function build(AbstractModel $model): void {
		$this->buildDocblock($model);

		$this->writeFunctionStatement($model);
		$this->writeBody($model);
	}

}
