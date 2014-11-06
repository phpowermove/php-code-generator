<?php
namespace gossi\codegen\generator;

use gossi\codegen\model\GenerateableInterface;
use gossi\codegen\config\CodeFileGeneratorConfig;
use gossi\docblock\Docblock;

class CodeFileGenerator extends CodeGenerator {
	
	/**
	 * @param CodeFileGeneratorConfig|array $config
	 */
	public function __construct($config = null) {
		if (is_array($config)) {
			$this->config = new CodeFileGeneratorConfig($config);
		} else if ($config === null) {
			$this->config = new CodeFileGeneratorConfig();
		} else if ($config instanceof CodeFileGeneratorConfig) {
			$this->config = $config;
		}
		
		$this->init();
	}
	
	/**
	 * @return CodeFileGeneratorConfig
	 */
	public function getConfig() {
		return $this->config;
	}
	
	public function generate(GenerateableInterface $model) {
		$content = "<?php\n";
		
		if (($comment = $this->config->getHeaderComment()) !== null) {
			$docblock = new Docblock();
			$docblock->setLongDescription($comment);
			$content .= str_replace('/**', '/*', $docblock->toString()) . "\n";
		}
		
		if ($this->config->getHeaderDocblock() instanceof Docblock) {
			$content .= $this->config->getHeaderDocblock()->toString() . "\n";
		}
		
		$content .= parent::generate($model);
		
		if ($this->config->getBlankLineAtEnd()) {
			$content .= "\n";
		}
		
		return $content;
	}
}
