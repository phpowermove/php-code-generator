<?php
namespace gossi\codegen\config;

use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Configuration for code generator
 * 
 * @author gossi
 */
class CodeGeneratorConfig {

	protected $options;

	/**
	 * Creates a new configuration for code generator
	 * 
	 * @see https://php-code-generator.readthedocs.org/en/latest/generator.html
	 * @param array $options
	 */
	public function __construct(array $options = []) {
		$resolver = new OptionsResolver();
		$resolver->setDefined($this->getOptionalOptions());
		$resolver->setDefaults($this->getDefaultOptions());
		foreach ($this->getAllowedOptionTypes() as $option => $type) {
			$resolver->setAllowedTypes($option, $type);
		}
		$this->options = $resolver->resolve($options);
	}

	protected function getOptionalOptions() {
		return [
			'generateDocblock',
			'generateEmptyDocblock',
			'generateScalarTypeHints',
			'generateReturnTypeHints',
		];
	}

	protected function getDefaultOptions() {
		return [
			'generateDocblock' => true,
			'generateEmptyDocblock' => function (Options $options) {
				return $options['generateDocblock'];
			},
			'generateScalarTypeHints' => false,
			'generateReturnTypeHints' => false,
		];
	}

	protected function getAllowedOptionTypes() {
		return [
			'generateDocblock' => 'bool',
			'generateEmptyDocblock' => 'bool',
			'generateScalarTypeHints' => 'bool',
			'generateReturnTypeHints' => 'bool',
		];
	}

	/**
	 * Returns whether docblocks should be generated
	 * 
	 * @return bool `true` if they will be generated and `false` if not
	 */
	public function getGenerateDocblock() {
		return $this->options['generateDocblock'];
	}

	/**
	 * Sets whether docblocks should be generated
	 *
	 * @param bool $generate `true` if they will be generated and `false` if not
	 * @return $this
	 */
	public function setGenerateDocblock($generate) {
		$this->options['generateDocblock'] = $generate;
		if (!$generate) {
			$this->options['generateEmptyDocblock'] = $generate;
		}
		return $this;
	}

	/**
	 * Returns whether empty docblocks are generated
	 * 
	 * @return bool `true` if they will be generated and `false` if not
	 */
	public function getGenerateEmptyDocblock() {
		return $this->options['generateEmptyDocblock'];
	}

	/**
	 * Sets whether empty docblocks are generated
	 *
	 * @param bool $generate `true` if they will be generated and `false` if not
	 * @return $this
	 */
	public function setGenerateEmptyDocblock($generate) {
		$this->options['generateEmptyDocblock'] = $generate;
		if ($generate) {
			$this->options['generateDocblock'] = $generate;
		}
		return $this;
	}

	/**
	 * Returns whether scalar type hints will be generated for method parameters (PHP 7)
	 * 
	 * @return bool `true` if they will be generated and `false` if not
	 */
	public function getGenerateScalarTypeHints() {
		return $this->options['generateScalarTypeHints'];
	}

	/**
	 * Sets whether scalar type hints will be generated for method parameters (PHP 7)
	 *
	 * @param bool $generate `true` if they will be generated and `false` if not
	 * @return $this
	 */
	public function setGenerateScalarTypeHints($generate) {
		$this->options['generateScalarTypeHints'] = $generate;
		return $this;
	}

	/**
	 * Returns whether return type hints will be generated for method parameters (PHP 7)
	 * 
	 * @return bool `true` if they will be generated and `false` if not
	 */
	public function getGenerateReturnTypeHints() {
		return $this->options['generateReturnTypeHints'];
	}

	/**
	 * Sets whether return type hints will be generated for method parameters (PHP 7)
	 *
	 * @param bool $generate `true` if they will be generated and `false` if not
	 * @return $this
	 */
	public function setGenerateReturnTypeHints($generate) {
		$this->options['generateReturnTypeHints'] = $generate;
		return $this;
	}
}
