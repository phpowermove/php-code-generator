<?php
declare(strict_types=1);

namespace phpowermove\codegen\config;

use phpowermove\code\profiles\Profile;
use phpowermove\codegen\generator\CodeGenerator;
use phootwork\lang\Comparator;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Configuration for code generation
 *
 * @author Thomas Gossmann
 */
class CodeGeneratorConfig {

	protected $options;

	/** @var Profile */
	protected $profile;

	/**
	 * Creates a new configuration for code generator
	 *
	 * @see https://php-code-generator.readthedocs.org/en/latest/generator.html
	 * @param array $options
	 */
	public function __construct(array $options = []) {
		$resolver = new OptionsResolver();
		$this->configureOptions($resolver);
		$this->options = $resolver->resolve($options);
		$this->profile = is_string($this->options['profile']) ? new Profile($this->options['profile']) : $this->options['profile'];
	}

	protected function configureOptions(OptionsResolver $resolver): void {
		$resolver->setDefaults([
			'profile' => 'default',
			'generateDocblock' => true,
			'generateEmptyDocblock' => function (Options $options) {
				return $options['generateDocblock'];
			},
			'generateScalarTypeHints' => false,
			'generateReturnTypeHints' => false,
			'generateNullableTypes' => false,
			'enableFormatting' => false,
			'enableSorting' => true,
			'useStatementSorting' => CodeGenerator::SORT_USESTATEMENTS_DEFAULT,
			'constantSorting' => CodeGenerator::SORT_CONSTANTS_DEFAULT,
			'propertySorting' => CodeGenerator::SORT_PROPERTIES_DEFAULT,
			'methodSorting' => CodeGenerator::SORT_METHODS_DEFAULT
		]);

		$resolver->setAllowedTypes('profile', ['string', 'phpowermove\code\profiles\Profile']);
		$resolver->setAllowedTypes('generateDocblock', 'bool');
		$resolver->setAllowedTypes('generateEmptyDocblock', 'bool');
		$resolver->setAllowedTypes('generateScalarTypeHints', 'bool');
		$resolver->setAllowedTypes('generateReturnTypeHints', 'bool');
		$resolver->setAllowedTypes('generateNullableTypes', 'bool');
		$resolver->setAllowedTypes('enableFormatting', 'bool');
		$resolver->setAllowedTypes('enableSorting', 'bool');
		$resolver->setAllowedTypes('useStatementSorting', ['bool', 'string', '\Closure', 'phootwork\lang\Comparator']);
		$resolver->setAllowedTypes('constantSorting', ['bool', 'string', '\Closure', 'phootwork\lang\Comparator']);
		$resolver->setAllowedTypes('propertySorting', ['bool', 'string', '\Closure', 'phootwork\lang\Comparator']);
		$resolver->setAllowedTypes('methodSorting', ['bool', 'string', '\Closure', 'phootwork\lang\Comparator']);
	}

	/**
	 * Returns the code style profile
	 *
	 * @return Profile
	 */
	public function getProfile(): Profile {
		return $this->profile;
	}

	/**
	 * Sets the code style profile
	 *
	 * @param Profile|string $profile
	 * @return $this
	 */
	public function setProfile($profile) {
		if (is_string($profile)) {
			$profile = new Profile($profile);
		}
		$this->profile = $profile;
		return $this;
	}

	/**
	 * Returns whether docblocks should be generated
	 *
	 * @return bool `true` if they will be generated and `false` if not
	 */
	public function getGenerateDocblock(): bool {
		return $this->options['generateDocblock'];
	}

	/**
	 * Sets whether docblocks should be generated
	 *
	 * @param bool $generate `true` if they will be generated and `false` if not
	 * @return $this
	 */
	public function setGenerateDocblock(bool $generate) {
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
	public function getGenerateEmptyDocblock(): bool {
		return $this->options['generateEmptyDocblock'];
	}

	/**
	 * Sets whether empty docblocks are generated
	 *
	 * @param bool $generate `true` if they will be generated and `false` if not
	 * @return $this
	 */
	public function setGenerateEmptyDocblock(bool $generate) {
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
	public function getGenerateScalarTypeHints(): bool {
		return $this->options['generateScalarTypeHints'];
	}

	/**
	 * Returns whether sorting is enabled
	 *
	 * @return bool `true` if it is enabled and `false` if not
	 */
	public function isSortingEnabled(): bool {
		return $this->options['enableSorting'];
	}

	/**
	 * Returns whether formatting is enalbed
	 *
	 * @return bool `true` if it is enabled and `false` if not
	 */
	public function isFormattingEnabled(): bool {
		return $this->options['enableFormatting'];
	}

	/**
	 * Returns the use statement sorting
	 *
	 * @return string|bool|Comparator|\Closure
	 */
	public function getUseStatementSorting() {
		return $this->options['useStatementSorting'];
	}

	/**
	 * Returns the constant sorting
	 *
	 * @return string|bool|Comparator|\Closure
	 */
	public function getConstantSorting() {
		return $this->options['constantSorting'];
	}

	/**
	 * Returns the property sorting
	 *
	 * @return string|bool|Comparator|\Closure
	 */
	public function getPropertySorting() {
		return $this->options['propertySorting'];
	}

	/**
	 * Returns the method sorting
	 *
	 * @return string|bool|Comparator|\Closure
	 */
	public function getMethodSorting() {
		return $this->options['methodSorting'];
	}

	/**
	 * Sets whether scalar type hints will be generated for method parameters (PHP 7)
	 *
	 * @param bool $generate `true` if they will be generated and `false` if not
	 * @return $this
	 */
	public function setGenerateScalarTypeHints(bool $generate) {
		$this->options['generateScalarTypeHints'] = $generate;
		return $this;
	}

	/**
	 * Returns whether return type hints will be generated for method parameters (PHP 7)
	 *
	 * @return bool `true` if they will be generated and `false` if not
	 */
	public function getGenerateReturnTypeHints(): bool {
		return $this->options['generateReturnTypeHints'];
	}

	/**
	 * Sets whether return type hints will be generated for method parameters (PHP 7)
	 *
	 * @param bool $generate `true` if they will be generated and `false` if not
	 * @return $this
	 */
	public function setGenerateReturnTypeHints(bool $generate) {
		$this->options['generateReturnTypeHints'] = $generate;
		return $this;
	}

	/**
	 * Returns whether return nullable type hints will be generated (PHP 7.3)
	 *
	 * @return bool `true` if they will be generated and `false` if not
	 */
	public function getGenerateNullableTypes(): bool {
		return $this->options['generateNullableTypes'];
	}

	/**
	 * Sets whether return nullable type hints will be generated (PHP 7.3)
	 *
	 * @param bool $generate `true` if they will be generated and `false` if not
	 * @return $this
	 */
	public function setGenerateNullableTypes(bool $generate) {
		$this->options['generateNullableTypes'] = $generate;
		return $this;
	}

	/**
	 * Sets whether sorting is enabled
	 *
	 * @param $enabled bool `true` if it is enabled and `false` if not
	 * @return $this
	 */
	public function setSortingEnabled(bool $enabled) {
		$this->options['enableSorting'] = $enabled;
		return $this;
	}

	/**
	 * Sets whether formatting is enabled
	 *
	 * @param $enabled bool `true` if it is enabled and `false` if not
	 * @return $this
	 */
	public function setFormattingEnabled(bool $enabled) {
		$this->options['enableFormatting'] = $enabled;
		return $this;
	}

	/**
	 * Returns the use statement sorting
	 *
	 * @param $sorting string|bool|Comparator|\Closure
	 * @return $this
	 */
	public function setUseStatementSorting($sorting) {
		$this->options['useStatementSorting'] = $sorting;
		return $this;
	}

	/**
	 * Returns the constant sorting
	 *
	 * @param $sorting string|bool|Comparator|\Closure
	 * @return $this
	 */
	public function setConstantSorting($sorting) {
		$this->options['constantSorting'] = $sorting;
		return $this;
	}

	/**
	 * Returns the property sorting
	 *
	 * @param $sorting string|bool|Comparator|\Closure
	 * @return $this
	 */
	public function setPropertySorting($sorting) {
		$this->options['propertySorting'] = $sorting;
		return $this;
	}

	/**
	 * Returns the method sorting
	 *
	 * @param $sorting string|bool|Comparator|\Closure
	 * @return $this
	 */
	public function setMethodSorting($sorting) {
		$this->options['methodSorting'] = $sorting;
		return $this;
	}
}
