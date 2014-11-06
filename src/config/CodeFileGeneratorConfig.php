<?php
namespace gossi\codegen\config;

use gossi\docblock\Docblock;
class CodeFileGeneratorConfig extends CodeGeneratorConfig {

	protected function getOptionalOptions() {
		return array_merge([
				'headerComment', 'headerDocblock', 'blankLineAtEnd'
			], parent::getOptionalOptions());
	}
	
	protected function getDefaultOptions() {
		return array_merge([
				'headerComment' => '',
				'headerDocblock' => null,
				'blankLineAtEnd' => true
			], parent::getDefaultOptions());
	}
	
	protected function getAllowedOptionTypes() {
		return array_merge([
				'headerComment' => 'string',
				'headerDocblock' => ['null', 'gossi\\docblock\\Docblock'],
				'blankLineAtEnd' => 'bool'
			], parent::getAllowedOptionTypes());
	}
	
	/**
	 * @return string
	 */
	public function getHeaderComment() {
		return $this->options['headerComment'];
	}
	
	/**
	 * 
	 * @param string $comment
	 * @return $this
	 */
	public function setHeaderComment($comment) {
		$this->options['headerComment'] = $comment;
		return $this;
	}

	/**
	 * @return Docblock
	 */
	public function getHeaderDocblock() {
		return $this->options['headerDocblock'];
	}
	
	/**
	 * 
	 * @param Docblock $docblock
	 * @return $this
	 */
	public function setHeaderDocblock(Docblock $docblock) {
		$this->options['headerDocblock'] = $docblock;
		return $this;
	}

	/**
	 * @return boolean
	 */
	public function getBlankLineAtEnd() {
		return $this->options['blankLineAtEnd'];
	}
	
	/**
	 * 
	 * @param boolean $show
	 * @return $this
	 */
	public function setBlankLineAtEnd($show) {
		$this->options['blankLineAtEnd'] = $show;
		return $this;
	}

}