<?php
namespace gossi\codegen\config;

use gossi\docblock\Docblock;
use Symfony\Component\OptionsResolver\Options;

class CodeFileGeneratorConfig extends CodeGeneratorConfig {

	protected function getOptionalOptions() {
		return array_merge([
				'headerComment', 'headerDocblock', 'blankLineAtEnd', 'declareStrictTypes'
			], parent::getOptionalOptions());
	}

	protected function getDefaultOptions() {
		return array_merge(
			parent::getDefaultOptions(), [
				'headerComment' => '',
				'headerDocblock' => null,
				'blankLineAtEnd' => true,
				'declareStrictTypes'  => false,
				'generateScalarTypeHints' => function (Options $options) {
					return $options['declareStrictTypes'];
				},
				'generateReturnTypeHints' => function (Options $options) {
					return $options['declareStrictTypes'];
				},
			]);
	}

	protected function getAllowedOptionTypes() {
		return array_merge([
				'headerComment' => 'string',
				'headerDocblock' => ['null', 'gossi\\docblock\\Docblock'],
				'blankLineAtEnd' => 'bool',
				'declareStrictTypes' => 'bool',
			], parent::getAllowedOptionTypes());
	}

	/**
	 * Returns the file header comment
	 * 
	 * @return string the header comment
	 */
	public function getHeaderComment() {
		return $this->options['headerComment'];
	}

	/**
	 * Sets the file header comment
	 * 
	 * @param string $comment the header comment
	 * @return $this
	 */
	public function setHeaderComment($comment) {
		$this->options['headerComment'] = $comment;
		return $this;
	}

	/**
	 * Returns the file header docblock
	 * 
	 * @return Docblock the docblock
	 */
	public function getHeaderDocblock() {
		return $this->options['headerDocblock'];
	}

	/**
	 * Sets the file header docblock
	 * 
	 * @param Docblock $docblock the docblock
	 * @return $this
	 */
	public function setHeaderDocblock(Docblock $docblock) {
		$this->options['headerDocblock'] = $docblock;
		return $this;
	}

	/**
	 * Returns whether a blank line should be generated at the end of the file
	 * 
	 * @return boolean `true` if it will be generated and `false` if not
	 */
	public function getBlankLineAtEnd() {
		return $this->options['blankLineAtEnd'];
	}

	/**
	 * Sets whether a blank line should be generated at the end of the file
	 * 
	 * @param boolean $show `true` if it will be generated and `false` if not
	 * @return $this
	 */
	public function setBlankLineAtEnd($show) {
		$this->options['blankLineAtEnd'] = $show;
		return $this;
	}

	/**
	 * Returns whether a `declare(strict_types=1);` statement should be printed 
	 * below the header comments (PHP 7)
	 * 
	 * @return boolean `true` if it will be printed and `false` if not
	 */
	public function getDeclareStrictTypes() {
		return $this->options['declareStrictTypes'];
	}

	/**
	 * Sets whether a `declare(strict_types=1);` statement should be printed 
	 * below the header comments (PHP 7)
	 * 
	 * @param boolean $strict `true` if it will be printed and `false` if not
	 * @return $this
	 */
	public function setDeclareStrictTypes($strict) {
		$this->options['declareStrictTypes'] = $strict;
		return $this;
	}
}
