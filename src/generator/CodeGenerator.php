<?php
namespace gossi\codegen\generator;

use gossi\codegen\config\CodeGeneratorConfig;
use gossi\codegen\model\GenerateableInterface;
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
		$visitor = new DefaultVisitor($this->config);
		$this->strategy = new DefaultGeneratorStrategy($visitor);
	}

	/**
	 * Returns the used configuration
	 * 
	 * @return CodeGeneratorConfig
	 */
	public function getConfig() {
		return $this->config;
	}

	/**
	 * Returns the used generator strategy
	 * 
	 * @return DefaultGeneratorStrategy
	 */
	public function getGeneratorStrategy() {
		return $this->strategy;
	}

	/**
	 * Generates code from a given model
	 * 
	 * @param GenerateableInterface $model
	 * @return string the generated code
	 */
	public function generate(GenerateableInterface $model) {
		if ($this->config->getGenerateDocblock()) {
			$model->generateDocblock();
		}

		return $this->strategy->generate($model);
	}

}
