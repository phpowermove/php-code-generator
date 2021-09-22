<?php
declare(strict_types=1);

namespace phpowermove\codegen\generator;

use phpowermove\codegen\config\CodeGeneratorConfig;
use phpowermove\codegen\generator\utils\Writer;
use phpowermove\codegen\model\AbstractModel;
use phpowermove\formatter\Formatter;

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

	/** @var Formatter */
	private $formatter;

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

		$profile = $this->config->getProfile();
		$this->writer = new Writer([
			'indentation_character' => $profile->getIndentation('character') == 'tab' ? "\t" : ' ',
			'indentation_size' => $profile->getIndentation('size')
		]);
		$this->formatter = new Formatter($profile);
		$this->factory = new BuilderFactory($this);
	}

	/**
	 */
	public function getConfig(): CodeGeneratorConfig {
		return $this->config;
	}

	/**
	 *
	 */
	public function getWriter(): Writer {
		return $this->writer;
	}

	/**
	 *
	 */
	public function getFactory(): BuilderFactory {
		return $this->factory;
	}

	/**
	 * @param AbstractModel $model
	 */
	public function generate(AbstractModel $model): string {
		$this->writer->reset();

		$builder = $this->factory->getBuilder($model);
		$builder->build($model);

		$code = $this->writer->getContent();

		if ($this->config->isFormattingEnabled()) {
			$code = $this->formatter->format($code);
		}

		return $code;
	}
}
