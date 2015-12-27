<?php
namespace gossi\codegen\parser;

use gossi\codegen\model\AbstractPhpStruct;
use gossi\codegen\parser\visitor\AbstractPhpStructVisitor;
use phootwork\file\exception\FileNotFoundException;
use phootwork\file\File;
use PhpParser\Lexer\Emulative;
use PhpParser\NodeTraverser;
use PhpParser\Parser;

class FileParser {
	
	/**
	 * 
	 * @param AbstractPhpStructVisitor $visitor
	 * @param string $filename
	 * @throws FileNotFoundException
	 * @return AbstractPhpStruct
	 */
	public function parse(AbstractPhpStructVisitor $visitor, $filename) {
		$file = new File($filename);
		
		if (!$file->exists()) {
			throw new FileNotFoundException(sprintf('File (%s) does not exist.', $filename));
		}
		
		$parser = new Parser(new Emulative());
		$traverser = new NodeTraverser();
		$traverser->addVisitor($visitor);
		$traverser->traverse($parser->parse($file->read()));
		
		return $visitor->getStruct();
	}
}