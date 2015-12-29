<?php
namespace gossi\codegen\generator;

use gossi\codegen\config\CodeFileGeneratorConfig;
use gossi\codegen\model\GenerateableInterface;
use gossi\docblock\Docblock;

/**
 * Code file generator.
 * 
 * Generates code for a model and puts it into a file with `<?php` statements. Can also
 * generate header comments. 
 * 
 * @author gossi
 */
class CodeFileGenerator extends CodeGenerator {

	/**
	 * Creates a new CodeFileGenerator
	 * 
	 * @see https://php-code-generator.readthedocs.org/en/latest/generator.html
	 * @param CodeFileGeneratorConfig|array $config
	 */
	public function __construct($config = null) {
		if (is_array($config)) {
			$this->config = new CodeFileGeneratorConfig($config);
		} else if ($config instanceof CodeFileGeneratorConfig) {
			$this->config = $config;
		} else {
			$this->config = new CodeFileGeneratorConfig();
		}

		$this->init();
	}

	/**
	 * {@inheritDoc}
	 * 
	 * @return CodeFileGeneratorConfig
	 */
	public function getConfig() {
		return $this->config;
	}

	/**
	 * {@inheritDoc}
	 */
	public function generate(GenerateableInterface $model) {
		$content = "<?php\n";

		$comment = $this->config->getHeaderComment();
		if (!empty($comment)) {
			$docblock = new Docblock();
			$docblock->setLongDescription($comment);
			$content .= str_replace('/**', '/*', $docblock->toString()) . "\n";
		}

		if ($this->config->getHeaderDocblock() instanceof Docblock) {
			$content .= $this->config->getHeaderDocblock()->toString() . "\n";
		}

		if ($this->config->getDeclareStrictTypes()) {
			$content .= "declare(strict_types=1);\n\n";
		}

		$content .= parent::generate($model);

		if ($this->config->getBlankLineAtEnd()) {
			$content .= "\n";
		}

		return $content;
	}
}
