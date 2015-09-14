<?php
namespace gossi\codegen\config;

use Symfony\Component\OptionsResolver\OptionsResolver;

class CodeGeneratorConfig {

	protected $options;

	public function __construct(array $options = []) {
		$resolver = new OptionsResolver();
		$resolver->setOptional($this->getOptionalOptions());
		$resolver->setAllowedTypes($this->getAllowedOptionTypes());
		$resolver->setDefaults($this->getDefaultOptions());
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
			'generateEmptyDocblock' => true,
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
	 * @return boolean
	 */
	public function getGenerateDocblock() {
		return $this->options['generateDocblock'];
	}

	/**
	 *
	 * @param boolean $generate
	 * @return $this
	 */
	public function setGenerateDocblock($generate) {
		$this->options['generateDocblock'] = $generate;
		return $this;
	}

	/**
	 * @return boolean
	 */
	public function getGenerateEmptyDocblock() {
		return $this->options['generateEmptyDocblock'];
	}

	/**
	 *
	 * @param boolean $generate
	 * @return $this
	 */
	public function setGenerateEmptyDocblock($generate) {
		$this->options['generateEmptyDocblock'] = $generate;
		return $this;
	}

	/**
	 * @return boolean
	 */
	public function getGenerateScalarTypeHints() {
		return $this->options['generateScalarTypeHints'];
	}

	/**
	 *
	 * @param boolean $generate
	 * @return $this
	 */
	public function setGenerateScalarTypeHints($generate) {
		$this->options['generateScalarTypeHints'] = $generate;
		return $this;
	}

	/**
	 * @return boolean
	 */
	public function getGenerateReturnTypeHints() {
		return $this->options['generateReturnTypeHints'];
	}

	/**
	 *
	 * @param boolean $generate
	 * @return $this
	 */
	public function setGenerateReturnTypeHints($generate) {
		$this->options['generateReturnTypeHints'] = $generate;
		return $this;
	}
}