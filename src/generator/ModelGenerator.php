<?php
namespace gossi\codegen\generator;

use gossi\codegen\config\CodeGeneratorConfig;
use gossi\codegen\generator\utils\Writer;
use gossi\codegen\model\AbstractModel;

/**
 * Model Generator
 *
 * @author Thomas Gossmann
 */
class ModelGenerator {

	/** @var Writer */
	private $writer;
	
	/** @var BuilderFactory */
	private $factory;
	
	/** @var CodeGeneratorConfig */
	private $config;

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
			$this->config = new CodeGeneratorConfig(['generateDocblock' => false]);
		}
		
		$this->writer = new Writer();
		$this->factory = new BuilderFactory($this);
	}
	
	/**
	 * @return CodeGeneratorConfig
	 */
	public function getConfig() {
		return $this->config;
	}
	
	/**
	 * @return Writer
	 */
	public function getWriter() {
		return $this->writer;
	}
	
	/**
	 * @return BuilderFactory
	 */
	public function getFactory() {
		return $this->factory;
	}

	/**
	 * @param AbstractModel $model
	 * @return string
	 */
	public function generate(AbstractModel $model) {
		$this->writer->reset();
		
		$builder = $this->factory->getBuilder($model);
		$builder->build($model);

		return $this->writer->getContent();
	}
}
