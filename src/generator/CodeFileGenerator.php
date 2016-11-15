<?php
namespace gossi\codegen\generator;

use gossi\codegen\config\CodeFileGeneratorConfig;
use gossi\codegen\model\GenerateableInterface;
use gossi\docblock\Docblock;
use phootwork\lang\Text;

/**
 * Code file generator.
 *
 * Generates code for a model and puts it into a file with `<?php` statements. Can also
 * generate header comments.
 *
 * @author Thomas Gossmann
 */
class CodeFileGenerator extends CodeGenerator {

	/**
	 * Creates a new CodeFileGenerator
	 *
	 * @see https://php-code-generator.readthedocs.org/en/latest/generator.html
	 * @param CodeFileGeneratorConfig|array $config
	 */
	public function __construct($config = null) {
		parent::__construct($config);
	}
	
	protected function configure($config = null) {
		if (is_array($config)) {
			$this->config = new CodeFileGeneratorConfig($config);
		} else if ($config instanceof CodeFileGeneratorConfig) {
			$this->config = $config;
		} else {
			$this->config = new CodeFileGeneratorConfig();
		}
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
		if ($comment !== null && !$comment->isEmpty()) {
			$content .= str_replace('/**', '/*', $comment->toString()) . "\n";
		}

		$docblock = $this->config->getHeaderDocblock();
		if ($docblock !== null && !$docblock->isEmpty()) {
			$content .= $docblock->toString() . "\n";
		}

		if ($this->config->getDeclareStrictTypes()) {
			$content .= "declare(strict_types=1);\n\n";
		}

		$content .= parent::generate($model);

		if ($this->config->getBlankLineAtEnd() && !Text::create($content)->endsWith("\n")) {
			$content .= "\n";
		}

		return $content;
	}
}
