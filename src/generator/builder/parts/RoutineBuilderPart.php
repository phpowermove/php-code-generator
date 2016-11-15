<?php
namespace gossi\codegen\generator\builder\parts;

use gossi\codegen\model\AbstractModel;
use gossi\codegen\model\RoutineInterface;

Trait RoutineBuilderPart {
	
	use TypeBuilderPart;
	
	protected abstract function generate(AbstractModel $model);
	
	protected function writeFunctionStatement(RoutineInterface $model) {
		$this->writer->write('function ');
		
		if ($model->isReferenceReturned()) {
			$this->writer->write('& ');
		}
		
		$this->writer->write($model->getName() . '(');
		$this->writeParameters($model);
		$this->writer->write(')');
		$this->writeFunctionReturnType($model);
	}
	
	protected function writeParameters(RoutineInterface $model) {
		$first = true;
		foreach ($model->getParameters() as $parameter) {
			if (!$first) {
				$this->writer->write(', ');
			}
			$first = false;
	
			$this->generate($parameter);
		}
	}
	
	protected function writeFunctionReturnType(RoutineInterface $model) {
		$type = $this->getType($model, $this->config->getGenerateReturnTypeHints());
		if ($type !== null) {
			$this->writer->write(': ')->write($type);
		}
	}
	
	protected function writeBody(RoutineInterface $model) {
		$this->writer->writeln(' {')->indent();
		$this->writer->writeln(trim($model->getBody()));
		$this->writer->outdent()->rtrim()->writeln("}");
	}
}
