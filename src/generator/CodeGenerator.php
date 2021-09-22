<?php
declare(strict_types=1);

namespace phpowermove\codegen\generator;

use phpowermove\codegen\config\CodeGeneratorConfig;
use phpowermove\codegen\model\GenerateableInterface;

/**
 * Code generator
 *
 * Generates code for any generateable model
 *
 * @author Thomas Gossmann
 */
class CodeGenerator {

	const SORT_USESTATEMENTS_DEFAULT = 'default';

	const SORT_CONSTANTS_DEFAULT = 'default';

	const SORT_PROPERTIES_DEFAULT = 'default';

	const SORT_METHODS_DEFAULT = 'default';

	/** @var CodeGeneratorConfig */
	protected $config;

	/** @var ModelGenerator */
	protected $generator;

	/**
	 *
	 * @param CodeGeneratorConfig|array $config
	 */
	public function __construct($config = null) {
		$this->configure($config);
		$this->generator = new ModelGenerator($this->config);
	}

	protected function configure($config = null) {
		if (is_array($config)) {
			$this->config = new CodeGeneratorConfig($config);
		} else if ($config instanceof CodeGeneratorConfig) {
			$this->config = $config;
		} else {
			$this->config = new CodeGeneratorConfig();
		}
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
	 * Generates code from a given model
	 *
	 * @param GenerateableInterface $model
	 * @return string the generated code
	 */
	public function generate(GenerateableInterface $model): string {
		return $this->generator->generate($model);
	}

}
