<?php
namespace gossi\codegen\config;

use gossi\docblock\Docblock;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Configuration for code file generation
 *
 * @author Thomas Gossmann
 */
class CodeFileGeneratorConfig extends CodeGeneratorConfig {
	
	protected function configureOptions(OptionsResolver $resolver) {
		parent::configureOptions($resolver);

		$resolver->setDefaults([
			'headerComment' => null,
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
		
		$resolver->setAllowedTypes('headerComment', ['null', 'string', 'gossi\\docblock\\Docblock']);
		$resolver->setAllowedTypes('headerDocblock', ['null', 'string', 'gossi\\docblock\\Docblock']);
		$resolver->setAllowedTypes('blankLineAtEnd', 'bool');
		$resolver->setAllowedTypes('declareStrictTypes', 'bool');
		
		$resolver->setNormalizer('headerComment', function (Options $options, $value) {
			return $this->toDocblock($value);
		});
		$resolver->setNormalizer('headerDocblock', function (Options $options, $value) {
			return $this->toDocblock($value);
		});
	}
	
	/**
	 * 
	 * @param mixed $value
	 * @return Docblock|null
	 */
	private function toDocblock($value) {
		if (is_string($value)) {
			$value = Docblock::create()->setLongDescription($value);
		}
		
		return $value;
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
	 * @return bool `true` if it will be generated and `false` if not
	 */
	public function getBlankLineAtEnd() {
		return $this->options['blankLineAtEnd'];
	}

	/**
	 * Sets whether a blank line should be generated at the end of the file
	 *
	 * @param bool $show `true` if it will be generated and `false` if not
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
	 * @return bool `true` if it will be printed and `false` if not
	 */
	public function getDeclareStrictTypes() {
		return $this->options['declareStrictTypes'];
	}

	/**
	 * Sets whether a `declare(strict_types=1);` statement should be printed
	 * below the header comments (PHP 7)
	 *
	 * @param bool $strict `true` if it will be printed and `false` if not
	 * @return $this
	 */
	public function setDeclareStrictTypes($strict) {
		$this->options['declareStrictTypes'] = $strict;
		return $this;
	}
}
