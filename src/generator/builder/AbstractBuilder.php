<?php
namespace gossi\codegen\generator\builder;

use gossi\codegen\config\CodeGeneratorConfig;
use gossi\codegen\generator\ModelGenerator;
use gossi\codegen\generator\utils\Writer;
use gossi\codegen\model\AbstractModel;
use gossi\codegen\model\DocblockInterface;

abstract class AbstractBuilder {

	/** @var ModelGenerator */
	protected $generator;
	
	/** @var Writer */
	protected $writer;
	
	/** @var CodeGeneratorConfig */
	protected $config;
	
	public function __construct(ModelGenerator $generator) {
		$this->generator = $generator;
		$this->writer = $generator->getWriter();
		$this->config = $generator->getConfig();
	}
	
	/**
	 * @param AbstractModel $model
	 * @return void
	 */
	abstract public function build(AbstractModel $model);
	
	/**
	 * @param AbstractModel $model
	 * @return void
	 */
	protected function generate(AbstractModel $model) {
		$builder = $this->generator->getFactory()->getBuilder($model);
		$builder->build($model);
	}
	
	/**
	 * @return void
	 */
	protected function ensureBlankLine() {
		if (!$this->writer->endsWith("\n\n") && strlen($this->writer->rtrim()->getContent()) > 0) {
			$this->writer->writeln();
		} 
	}
	
	/**
	 * @param DocblockInterface $model
	 * @return void
	 */
	protected function buildDocblock(DocblockInterface $model) {
		$this->ensureBlankLine();
		if ($this->config->getGenerateDocblock()) {
			$model->generateDocblock();
		}
		$docblock = $model->getDocblock();
		if (!$docblock->isEmpty() || $this->config->getGenerateEmptyDocblock()) {
			$this->writer->writeln($docblock->toString());
		}
	}
	
}