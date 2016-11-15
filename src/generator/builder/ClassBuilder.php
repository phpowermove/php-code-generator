<?php
namespace gossi\codegen\generator\builder;

use gossi\codegen\model\AbstractModel;
use gossi\codegen\model\PhpClass;
use gossi\codegen\generator\builder\parts\StructBuilderPart;

class ClassBuilder extends AbstractBuilder {
	
	use StructBuilderPart;

	public function build(AbstractModel $model) {
		$this->sort($model);
		
		$this->buildHeader($model);
		
		// signature
		$this->buildSignature($model);
		
		// body
		$this->writer->writeln(" {\n")->indent();
		$this->buildTraits($model);
		$this->buildConstants($model);
		$this->buildProperties($model);
		$this->buildMethods($model);
		$this->writer->outdent()->rtrim()->write('}');
	}
	
	private function buildSignature(PhpClass $model) {
		if ($model->isAbstract()) {
			$this->writer->write('abstract ');
		}
		
		if ($model->isFinal()) {
			$this->writer->write('final ');
		}
		
		$this->writer->write('class ');
		$this->writer->write($model->getName());
		
		if ($parentClassName = $model->getParentClassName()) {
			$this->writer->write(' extends ' . $parentClassName);
		}
		
		if ($model->hasInterfaces()) {
			$this->writer->write(' implements ');
			$this->writer->write(implode(', ', $model->getInterfaces()->toArray()));
		}
	}
	
	private function sort(PhpClass $model) {
		$this->sortUseStatements($model);
		$this->sortConstants($model);
		$this->sortProperties($model);
		$this->sortMethods($model);
	}

}
