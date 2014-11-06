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
		return ['generateDocblock', 'generateEmptyDocblock'];
	}
	
	protected function getDefaultOptions() {
		return [
			'generateDocblock' => true,
			'generateEmptyDocblock' => true
		];
	}
	
	protected function getAllowedOptionTypes() {
		return [
			'generateDocblock' => 'bool',
			'generateEmptyDocblock' => 'bool',
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
}