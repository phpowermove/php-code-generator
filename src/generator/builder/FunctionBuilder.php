<?php
namespace gossi\codegen\generator\builder;

use gossi\codegen\generator\builder\parts\RoutineBuilderPart;
use gossi\codegen\model\AbstractModel;

class FunctionBuilder extends AbstractBuilder {
	
	use RoutineBuilderPart;

	public function build(AbstractModel $model) {
		$this->buildDocblock($model);
		
		$this->writeFunctionStatement($model);
		$this->writeBody($model);
	}

}