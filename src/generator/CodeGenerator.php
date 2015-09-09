<?php
namespace gossi\codegen\generator;

use gossi\codegen\model\GenerateableInterface;
use gossi\codegen\config\CodeGeneratorConfig;
use gossi\codegen\visitor\EmptyDocblockVisitor;
use gossi\codegen\visitor\DefaultVisitor;

class CodeGenerator {

	protected $config;

	/**
	 * @var DefaultGeneratorStrategy
	 */
	protected $strategy;

	/**
	 *
	 * @param CodeGeneratorConfig|array $config
	 */
	public function __construct($config = null) {
	if (is_array($config)) {
			$this->config = new CodeGeneratorConfig($config);
		} else if ($config instanceof CodeGeneratorConfig) {
			$this->config = $config;
		} else {
			$this->config = new CodeGeneratorConfig();
		}

		$this->init();
	}

	protected function init() {
		if ($this->config->getGenerateEmptyDocblock()) {
			$visitor = new EmptyDocblockVisitor(
				$this->config->getGenerateScalarTypeHints(),
				$this->config->getGenerateReturnTypeHints()
			);
		} else {
			$visitor = new DefaultVisitor(
				$this->config->getGenerateScalarTypeHints(),
				$this->config->getGenerateReturnTypeHints()
			);
		}
		$this->strategy = new DefaultGeneratorStrategy($visitor);
	}

	/**
	 * @return CodeGeneratorConfig
	 */
	public function getConfig() {
		return $this->config;
	}

	public function getGeneratorStrategy() {
		return $this->strategy;
	}

	public function generate(GenerateableInterface $model) {
		if ($this->config->getGenerateDocblock()) {
			$model->generateDocblock();
		}

		return $this->strategy->generate($model);
	}

}
